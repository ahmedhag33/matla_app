<?php

namespace App\Http\Controllers\Workspace;

use App\Events\Workspace\ProgramCreated;
use App\Events\Workspace\ProgramMemberCreated;
use App\Events\Workspace\ProgramMemberDeleted;
use App\Events\Workspace\ProgramUpdated;
use App\Exceptions\DatabaseException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Workspace\ProgramStepRequest;
use App\Models\Member;
use App\Models\Program;
use App\Models\ProgramTypes;
use App\Service\Base\JsonAPIMessages;
use App\Service\Enum\HttpStatusCode;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    use JsonAPIMessages;
    /**
     * Display the program index page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $programs = Program::with(['type', 'createdBy', 'broadcastDays'])->paginate(6);
        // Retrieve all program types.
        $programsTypes = ProgramTypes::all();
        // Retrieve all members with the role of presenter in the current workspace.
        $members = Member::inWorkspace()->notWorkspaceCreators()->get();
        // Retrieve all programs with their related type, creator, presenters, and broadcast days.
        return view('workspace.program.index', compact('programs', 'programsTypes', 'members'));
    }
    /**
     * retrieve the program details by slug.
     *
     * @return \Illuminate\View\View
     */
    public function details()
    {
        $programDays = programDays(request()->route('programSlug'));
        // Retrieve the broadcast days for the program.
        $program = Program::with([
            'type',
            'createdBy',
            'teamMembers' => function ($query) {
                $query->with('role');
            },
            'broadcastDays',
            'episodes' => function ($query) {
                $query->with('creator')
                    ->orderBy('episode_number', 'desc');
            }
        ])->withCount('teamMembers','episodes')
            ->where('slug', request()->route('programSlug'))
            ->firstOrFail();
        // Convert the broadcast days to a string representation.
        $programDaysTostring = implode(' ', collect($program->broadcastDays)->pluck('day_at_from_enum')->toArray());
        // Return the program details view with the retrieved program.
        return view('workspace.program.details.index', compact('program', 'programDays', 'programDaysTostring'));
    }
    /**
     * Handle the program step request.
     *
     * @param  ProgramStepRequest  $request
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function step(ProgramStepRequest $request)
    {
        try {
            return $this->returnData(['step' => $request->route('step'), 'data' => $request->validated()]);
        } catch (HttpResponseException $e) {
            return $e->getResponse();
        } catch (\Exception $e) {
            return $this->errorException(HttpStatusCode::INTERNAL_SERVER_ERROR->value, __('An unexpected error occurred.'));
        }
    }
    /**
     * Handle the program creation request.
     *
     * @param  ProgramStepRequest  $request
     * @return \Illuminate\Http\JsonResponse|string
     * @throws HttpResponseException
     * @throws \Exception
     */
    public function create(ProgramStepRequest $request)
    {
        try {
            $programId = $request->input('program_id');
            // Run the database transaction to create or update the program.
            $result = (array) runTransaction(function () use ($request, $programId) {
                // Retrieve the existing program if programId is provided, otherwise create a new instance.
                $program = $programId
                    ? Program::findOrFail($programId)
                    : new Program();
                // Determine whether this is a new program
                $isNew = !$program->exists;
                // Capture old values before updating
                $oldValues = $program->getRawOriginal();
                // Fill the program with the request data and save it.
                $program->fill([
                    'name' => $request->input('name'),
                    'slug' => $request->input('slug'),
                    'description' => $request->input('description'),
                    'program_type_id' => $request->input('program_type_id'),
                    'broadcast_mode' => $request->input('broadcast_mode'),
                    'broadcast_schedule' => $request->input('broadcast_schedule'),
                    'default_duration_minutes' => create_all_duration_minutes(
                        $request->input('duration_hours'),
                        $request->input('duration_minutes')
                    ),
                ]);
                $program->save();
                // Capture changed values
                $changes = $program->getChanges();

                $team_members = $request->input('team_members', []);
                // Synchronize team members with the program.
                $team_members_query = $program->teamMembers();
                // Capture the changes in team members after synchronization
                $team_members_changes = $team_members_query->sync($team_members);
                // Capture the changes in team members after synchronization
                $new_team_members = $team_members_changes['attached'];
                // Capture the removed team members after synchronization
                $removed_team_members = $team_members_changes['detached'];
                // Get old broadcast days before synchronization
                $oldDays = $program->broadcastDays()
                    ->get()
                    ->sortBy('day')
                    ->map(fn($broadcastDay) => $broadcastDay->day_at_from_enum)
                    ->values()
                    ->all();
                // Delete existing broadcast days before synchronizing new ones.
                $program->broadcastDays()->delete();
                // Synchronize broadcast days
                $syncChanges = $program->broadcastDays()->createMany(
                    collect($request->input('days_of_the_week', []))
                        ->map(fn($day) => ['day' => $day])
                        ->all()
                );
                // Get new broadcast days after synchronization
                $newDays = $program->broadcastDays()
                    ->get()
                    ->sortBy('day')
                    ->map(fn($broadcastDay) => $broadcastDay->day_at_from_enum)
                    ->values()
                    ->all();
                return [
                    'program' => $program,
                    'is_new' => $isNew,
                    'old_values' => $oldValues,
                    'changes' => $changes,
                    'sync_changes' => $syncChanges,
                    'new_team_members' => $new_team_members,
                    'removed_team_members' => $removed_team_members,
                    'old_days' => $oldDays,
                    'new_days' => $newDays,
                ];
            });
            $members = Member::notEqualCurrentUser()->inProgramTeam($result['program']->id)->inWorkspace()->get();
            // Extract old and new values for comparison
            $old = $result['old_values'];
            // Extract new values for comparison
            $new = $result['changes'];
            // Extract old and new broadcast days for comparison
            if ($result['is_new']) {
                // Notify program members about program creation.
                foreach ($members as $member) {
                    event(new ProgramCreated(
                        $result['program']->id,
                        $result['program']->name,
                        $result['program']->slug,
                        $member->id,
                        current_workspace()->id,
                        current_workspace()->slug
                    ));
                }
            } else {
                foreach ($members as $member) {
                    // Notify program members about program updates.
                    if (array_key_exists('name', $new)) {
                        event(new ProgramUpdated(
                            $result['program']->id,
                            __('Program name updated.'),
                            $old['name'],
                            $new['name'],
                            $result['program']->slug,
                            $member->id,
                            current_workspace()->id,
                            current_workspace()->slug
                        ));
                    }
                    // Notify program members about changes in broadcast days.
                    if ($result['old_days'] !== $result['new_days']) {
                        $oldDaysString = implode(', ', $result['old_days']);
                        $newDaysString = implode(', ', $result['new_days']);

                        event(new ProgramUpdated(
                            $result['program']->id,
                            __('Program broadcast days updated.'),
                            $oldDaysString,
                            $newDaysString,
                            $result['program']->slug,
                            $member->id,
                            current_workspace()->id,
                            current_workspace()->slug
                        ));
                    }
                }
            }
            // Notify newly added team members only once.
            foreach ($result['new_team_members'] as $team_member_id) {
                event(new ProgramMemberCreated(
                    $result['program']->id,
                    $result['program']->name,
                    $result['program']->slug,
                    $team_member_id,
                    current_workspace()->id,
                    current_workspace()->slug
                ));
            }
            // Notify removed team members only once.
            foreach ($result['removed_team_members'] as $team_member_id) {
                event(new ProgramMemberDeleted(
                    $result['program']->id,
                    $result['program']->name,
                    $result['program']->slug,
                    $team_member_id,
                    current_workspace()->id,
                    current_workspace()->slug
                ));
            }
            // Flash a success message to the session
            session()->flash('success-message-program', $result['is_new']
                ? __('Program created successfully.')
                : __('Program updated successfully.'));
            // Return the response with the redirect URL
            return $this->returnData([
                'error' => false,
                'url' => route('workspace.program.index', ['slug' => request()->route('slug')])
            ]);
        } catch (HttpResponseException $e) {
            return $e->getResponse();
        } catch (\Exception $e) {
            return $this->errorException(HttpStatusCode::INTERNAL_SERVER_ERROR->value, $e->getMessage());
        }
    }
    /**
     * Get a program by its ID along with its broadcast days.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws DatabaseException
     * @throws \Exception
     */
    public function getById(Request $request)
    {
        try {
            $programId = $request->input('program_id');
            // get the program by ID with its broadcast days
            $program = Program::with(['broadcastDays', 'teamMembers'])->where('id', $programId);
            // Check if the program exists in the database
            if ($program->doesntExist()) {
                throw new DatabaseException(HttpStatusCode::NOT_FOUND->value, __('Program not found.'));
            }
            // Get the first result from the query
            $program = $program->first();
            // Return the program with its broadcast days
            return $this->returnData([
                'error' => false,
                'program' => $program,
                'team_members' => $program->teamMembers,
            ]);
        } catch (DatabaseException $e) {
            return $this->errorException($e->getCode(), $e->getMessage());
        } catch (\Exception $e) {
            return $this->errorException(HttpStatusCode::INTERNAL_SERVER_ERROR->value, $e->getMessage());
        }
    }
    /**
     * Delete a program by its ID.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws DatabaseException
     * @throws \Exception
     */
    public function delete(Request $request)
    {
        try {
            $programId = $request->input('id');
            // Find the program by ID
            $program = Program::find($programId);
            // Check if the program exists
            if (!$program) {
                throw new DatabaseException(HttpStatusCode::NOT_FOUND->value, __('Program not found.'));
            }
            // Delete the program from the database
            $program->delete();
            // Return a success message after deletion
            return $this->returnData([
                'error' => false,
                'message' => __('Program deleted successfully.')
            ]);
        } catch (DatabaseException $e) {
            return $this->errorException($e->getCode(), $e->getMessage());
        } catch (\Exception $e) {
            return $this->errorException(HttpStatusCode::INTERNAL_SERVER_ERROR->value, $e->getMessage());
        }
    }
}
