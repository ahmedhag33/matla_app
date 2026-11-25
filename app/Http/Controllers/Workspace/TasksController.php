<?php

namespace App\Http\Controllers\Workspace;

use App\Exceptions\DatabaseException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Workspace\TaskRequest;
use App\Models\Episode;
use App\Models\Member;
use App\Models\Program;
use App\Models\Segments;
use App\Models\Tasks;
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
     * Retrieve all tasks with pagination and sorting.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function all(Request $request)
    {
        try {
            $query = Tasks::with([
                'episode' => function ($query) {
                    $query->with('program');
                },
                'segment',
                'member'
            ]);
            $itemsCount = (clone $query)->count();
            // Define the fields that can be used for sorting the tasks list.
            $sortableFields = [
                'title' => 'title',
            ];
            // Determine the sort field from the request parameters
            $sortField = $request->input('sortField', 'title');
            // Determine the sort order from the request parameters
            $sortOrder = strtolower($request->input('sortOrder', 'desc'));
            // Validate the sort order
            if (!in_array($sortOrder, ['asc', 'desc'], true)) {
                $sortOrder = 'desc';
            }
            // Apply sorting to the query based on the validated sort field and order
            $query->orderBy($sortableFields[$sortField], $sortOrder);
            // Pagination
            $pageIndex = max(1, (int) $request->input('pageIndex', 1));
            // Determine the page size for pagination
            $pageSize = min(
                100,
                max(1, (int) $request->input('pageSize', 10))
            );
            // Retrieve the paginated episodes based on the calculated page index and page size
            $tasks = $query
                ->skip(($pageIndex - 1) * $pageSize)
                ->take($pageSize)
                ->get();
            // Map the tasks to include only necessary data for the response.
            $data = $tasks->map(function ($task) {
                return [
                    'id' => $task->id,
                    'content' => $task->content_string ?? '',
                    'title' => $task->title,
                    'episode' => $task->episode->title.'-'.$task->episode->program->name,
                    'segment' => __('Segment Number') . ' ' . $task->segment->segment_number.'-'.$task->segment->name ?? '',
                    'member' => $task->member->name ?? '',
                    'due_at' => $task->due_at_formatted ?? '',
                    'completed_at' => $task->completed_at_formatted ?? '',
                    'status' => $task->status_formatted ?? '',
                    'priority' => $task->priority_formatted ?? ''
                ];
            });
            // Return the mapped tasks data along with the total items count.
            return $this->returnData([
                'data' => $data ?? [],
                'itemsCount' => $itemsCount,
            ]);
        } catch (\Exception $e) {
            return $this->errorException(HttpStatusCode::INTERNAL_SERVER_ERROR->value, __('An error occurred. Please try again.'));
        }
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
