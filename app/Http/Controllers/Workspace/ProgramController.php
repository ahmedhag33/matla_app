<?php

namespace App\Http\Controllers\Workspace;

use App\Events\Workspace\ProgramCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Workspace\ProgramStepRequest;
use App\Models\Member;
use App\Models\Program;
use App\Models\ProgramTypes;
use App\Service\Base\JsonAPIMessages;
use App\Service\Enum\HttpStatusCode;
use Illuminate\Http\Exceptions\HttpResponseException;

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
        $programs = Program::with(['type', 'createdBy', 'presenters', 'broadcastDays'])->get();
        // Retrieve all program types.
        $programsTypes = ProgramTypes::all();
        // Retrieve all members with the role of presenter in the current workspace.
        $presenters = Member::inWorkspace()->equalRole('presenter')->get();
        // Retrieve all programs with their related type, creator, presenters, and broadcast days.
        return view('workspace.program.index', compact('programs', 'programsTypes', 'presenters'));
    }
    /**
     * retrieve the program details by slug.
     *
     * @param  string  $programSlug
     * @return \Illuminate\View\View
     */
    public function details($programSlug)
    {
        $program = Program::with(['type', 'createdBy', 'presenters', 'broadcastDays'])
        ->where('slug', $programSlug)->first();
        // Return the program details view with the retrieved program.
        return view('workspace.program.details.index', compact('program'));
    }
    /**
     * Handle the program step request.
     *
     * @param  ProgramStepRequest  $request
     * @param  int  $step
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function step(ProgramStepRequest $request, $step)
    {
        try {
            return $this->returnData(['step' => $step, 'data' => $request->validated()]);
        } catch (HttpResponseException $e) {
            return $e->getResponse();
        } catch (\Exception $e) {
            return $this->errorException(HttpStatusCode::INTERNAL_SERVER_ERROR->value, __('An unexpected error occurred.'));
        }
    }
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
                // Synchronize broadcast days
                $syncChanges = $program->broadcastDays()->createMany(
                    collect($request->input('days_of_the_week', []))
                        ->map(fn($day) => ['day' => $day])
                        ->all()
                );
                return [
                    'program' => $program,
                    'is_new' => $isNew,
                    'old_values' => $oldValues,
                    'changes' => $changes,
                    'sync_changes' => $syncChanges,
                ];
            });
            $members = Member::notEqualCurrentUser()->inWorkspace()->get();
            // Perform any additional logic with the members if needed.
            if ($result['is_new']) {
                // Notify members about the new program
                foreach ($members as $member) {
                    event(new ProgramCreated(
                        $result['program']->id,
                        $result['program']->name,
                        $result['program']->slug,
                        $member->id,
                        current_workspace()->id
                    ));
                }
            }
            // Flash a success message to the session
            session()->flash('success-message-program', __('Program created successfully.'));
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
}
