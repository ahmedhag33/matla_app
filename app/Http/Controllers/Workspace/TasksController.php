<?php

namespace App\Http\Controllers\Workspace;

use App\Exceptions\DatabaseException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Workspace\TaskRequest;
use App\Models\Episode;
use App\Models\Member;
use App\Models\Program;
use App\Models\Segments;
use App\Service\Base\JsonAPIMessages;
use App\Service\Enum\HttpStatusCode;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    use JsonAPIMessages;
    /**
     * Display a listing of the tasks.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $programs = Program::get();
        // Retrieve all programs to populate the program select dropdown in the view.
        return view('workspace.tasksManagment.tasks.index', compact('programs'));
    }
    /**
     * Search for episodes based on the selected program.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws DatabaseException
     * @throws \Exception
     */
    public function search(Request $request)
    {
        try {
            $programId = $request->input('program_id');
            // Retrieve episodes for the selected program.
            $episodes = Episode::where('program_id', $programId);
            // Execute the query to get the episodes.
            $episodes = $episodes->get();
            // Retrieve members associated with the program.
            $members = Member::with('role')->inProgramTeam($programId)->get();
            // Map episodes to include only necessary data for the response.
            $episodes = $episodes->map(function ($episode) {
                return [
                    'id' => $episode->id,
                    'title' => __('Number Episode') . ' ' . $episode->episode_number . ' ' . $episode->title
                ];
            });
            $members = $members->map(function ($member) {
                return [
                    'id' => $member->id,
                    'name' => $member->name . '-' . $member->role->name ?? '',
                ];
            });
            // Return the episodes data if found.
            return $this->returnData([
                'episodes' => $episodes ?? [],
                'members' => $members ?? []
            ]);
        } catch (\Exception $e) {
            return $this->errorException(HttpStatusCode::INTERNAL_SERVER_ERROR->value, __('An error occurred. Please try again.'));
        }
    }
    /**
     * Search for segments based on the selected episode.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws DatabaseException
     * @throws \Exception
     */
    public function searchSegments(Request $request)
    {
        try {
            $episodeId = $request->input('episode_id');
            // Retrieve segments for the selected episode.
            $segments = Segments::where('episode_id', $episodeId)->get();
            // Map segments to include only necessary data for the response.
            $segments = $segments->map(function ($segment) {
                return [
                    'id' => $segment->id,
                    'name' => __('Segment Number') . ' ' . $segment->segment_number . ' ' . $segment->name,
                ];
            });
            return $this->returnData([
                'segments' => $segments ?? []
            ]);
        } catch (\Exception $e) {
            return $this->errorException(HttpStatusCode::INTERNAL_SERVER_ERROR->value, __('An error occurred. Please try again.'));
        }
    }
    /**
     * Handle the step request for a task.
     *
     * @param TaskRequest $request
     * @return \Illuminate\Http\JsonResponse|string
     * @throws HttpResponseException
     * @throws \Exception
     */
    public function step(TaskRequest $request)
    {
        try {
            return $this->returnData(['step' => $request->route('taskStep'), 'data' => $request->validated()]);
        } catch (HttpResponseException $e) {
            return $e->getResponse();
        } catch (\Exception $e) {
            return $this->errorException(HttpStatusCode::INTERNAL_SERVER_ERROR->value, __('An unexpected error occurred.'));
        }
    }
}
