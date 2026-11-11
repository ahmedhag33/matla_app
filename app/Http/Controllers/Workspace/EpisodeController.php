<?php

namespace App\Http\Controllers\Workspace;

use App\Http\Controllers\Controller;
use App\Http\Requests\Workspace\EpisodeRequest;
use App\Models\Program;
use App\Service\Base\JsonAPIMessages;
use App\Service\Enum\HttpStatusCode;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Carbon;
//use Illuminate\Http\Request;

class EpisodeController extends Controller
{
    use JsonAPIMessages;
    /**
     * Handle the step request for an episode.
     *
     * @param EpisodeRequest $request
     * @return \Illuminate\Http\JsonResponse|string
     * @throws HttpResponseException
     */
    public function step(EpisodeRequest $request)
    {
        try {
            return $this->returnData(['step' => $request->route('step'), 'data' => $request->validated()]);
        } catch (HttpResponseException $e) {
            return $e->getResponse();
        } catch (\Exception $e) {
            return $this->errorException(HttpStatusCode::INTERNAL_SERVER_ERROR->value, $e->getMessage());
        }
    }
    /**
     * Handle the create request for an episode.
     *
     * @param EpisodeRequest $request
     * @return \Illuminate\Http\JsonResponse|string
     * @throws HttpResponseException
     */
    public function create(EpisodeRequest $request)
    {
        try {
            $programId = $request->input('program_id');
            // Find the program by ID or fail if not found
            $program = Program::findOrFail($programId);
            // Run the transaction to create or update the episode
            $result = (array) runTransaction(function () use ($program, $request) {
                // Retrieve the episode ID from the request
                $episode_id = $request->input('episode_id');
                // Retrieve the title from the request
                $title = $request->input('title');
                // Get the description from the request
                $description = $request->input('description');
                // Convert the air date and time to the database format
                $air_at = convertArabicDateTimeToDatabase($request->input('air_date') . ' ' . $request->input('air_time'));
                // Calculate the total duration in minutes
                $duration = create_all_duration_minutes($request->input('duration_hours'), $request->input('duration_minutes'));
                // Create the episode with the retrieved data
                $episode = $program->episodes();
                //
                $createOrUpdate = $episode_id ? $episode->findOrFail($episode_id) : $episode->make();
                // Determine if the episode is new based on its existence before saving
                $isNew = !$createOrUpdate->exists;
                // Calculate the reminder time based on the air date and the reminder settings
                $reminder_at = $request->input('reminder_before_air')
                    ? Carbon::parse($air_at)->subDays($request->input('reminder_time'))
                    : null;
                // Fill the episode with the retrieved data and save it
                $createOrUpdate->fill([
                    'title' => $title,
                    'description' => $description,
                    'air_at' => $air_at,
                    'duration' => $duration,
                    'reminder_before_air' => ($request->input('reminder_before_air') == 1) ? 1 : 0,
                    'reminder_at' => $reminder_at,
                ]);
                $createOrUpdate->save();
                // Get the changes made to the episode after saving
                $newEpisode = $createOrUpdate->getChanges();
                // Return whether the episode is new and the changes made to it
                return ['is_new' => $isNew, 'episode' => $newEpisode];
            });
            session()->flash('success-create-episode', $result['is_new'] ? __('Episode created successfully.') : __('Episode updated successfully.'));
            // Return the result of the transaction as a JSON response
            return $this->returnData([
                'error' => false,
                'data' => $result,
                'url' => route('workspace.program.details', [
                    'slug' => current_workspace()->slug,
                    'programSlug' => $program->slug
                ])
            ]);
        } catch (HttpResponseException $e) {
            return $e->getResponse();
        } catch (\Exception $e) {
            return $this->errorException(HttpStatusCode::INTERNAL_SERVER_ERROR->value, $e->getMessage());
        }
    }
}
