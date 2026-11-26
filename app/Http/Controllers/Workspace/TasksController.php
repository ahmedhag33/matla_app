<?php

namespace App\Http\Controllers\Workspace;

use App\Events\Workspace\NotifyToMemberTask;
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
                'episode.program',
                'segment',
                'assignee'
            ]);
            // Count the total number of items before pagination.
            $itemsCount = (clone $query)->count();
            // Define the fields that can be used for sorting.
            $sortableFields = [
                'title' => 'title',
            ];
            // Get the sort field from the request, defaulting to 'title'.
            $sortField = $request->input('sortField', 'title');
            // Validate the sort field against the allowed sortable fields.
            if (!isset($sortableFields[$sortField])) {
                $sortField = 'title';
            }
            // Get the sort order from the request, defaulting to 'desc'.
            $sortOrder = strtolower($request->input('sortOrder', 'desc'));
            // Validate the sort order.
            if (!in_array($sortOrder, ['asc', 'desc'], true)) {
                $sortOrder = 'desc';
            }
            // Apply the sorting to the query.
            $query->orderBy($sortableFields[$sortField], $sortOrder);
            // Get the current page index from the request, defaulting to 1.
            $pageIndex = max(1, (int) $request->input('pageIndex', 1));
            // Get the page size from the request, defaulting to 10 and limiting to 100.
            $pageSize = min(100, max(1, (int) $request->input('pageSize', 10)));
            // Retrieve the tasks for the current page with the specified page size.
            $tasks = $query
                ->skip(($pageIndex - 1) * $pageSize)
                ->take($pageSize)
                ->get();
            // Map the tasks to the desired data structure.
            $data = $tasks->map(function ($task) {
                return [
                    'id' => $task->id,
                    'content' => $task->content_string ?? '',
                    'title' => $task->title ?? '',
                    'episode' => $task->episode
                        ? $task->episode->title . ' - ' . ($task->episode->program->name ?? '')
                        : '',
                    'segment' => $task->segment
                        ? __('Segment Number') . ' ' .
                        $task->segment->segment_number . ' - ' .
                        $task->segment->title
                        : __('Public'),
                    'member' => $task->assignee->name ?? '',
                    'due_at' => $task->due_at_formatted ?? '',
                    'completed_at' => $task->completed_at_formatted ?? __('Not Completed'),
                    'status' => $task->status_formatted ?? '',
                    'priority' => $task->priority_formatted ?? '',
                ];
            });
            return $this->returnData([
                'data' => $data,
                'itemsCount' => $itemsCount,
            ]);

        } catch (\Exception $e) {

            report($e);

            return $this->errorException(
                HttpStatusCode::INTERNAL_SERVER_ERROR->value,
                __('An error occurred. Please try again.')
            );
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
    public function create(TaskRequest $request)
    {
        try {
            $create = (object) runTransaction(function () use ($request) {
                $episodeId = $request->input('episode_id');
                // Retrieve the task context from the request.
                $task_context = $request->input('task_context');
                // Retrieve the segment ID from the request.
                $segmentId = ($task_context == 'segment') ? $request->input('segment_id') : null;
                // Retrieve the content type from the request.
                $content_type = $request->input('content_type');
                // Retrieve the description from the request.
                $description = $request->input('description');
                // Retrieve the requirements from the request.
                $requirements = $request->input('requirements', []);
                // Retrieve the reference URL from the request.
                $reference_url = $request->input('reference_url');
                // Retrieve the due date from the request.
                $due_date = $request->input('due_date');
                // Retrieve the due time from the request.
                $due_time = $request->input('due_time');
                // Convert the air date and air time to the database format.
                $due_at = convertArabicDateTimeToDatabase($due_date . ' ' . $due_time);
                // Retrieve the assigned ID from the request.
                $assigned_id = $request->input('assigned_id');
                // Retrieve the priority from the request.
                $priority = $request->input('priority');
                // create the task with the retrieved data.
                $create = Tasks::create([
                    'episode_id' => $episodeId,
                    'task_context' => $task_context,
                    'segment_id' => $segmentId,
                    'content_type' => $content_type,
                    'content_id' => $request->input('content_id'),
                    'title' => $request->input('title'),
                    'description' => $description,
                    'requirements' => $requirements,
                    'source' => $reference_url,
                    'assigned_id' => $assigned_id,
                    'priority' => $priority,
                    'due_at' => $due_at,
                    'completed_at' => $request->input('completed_at'),
                ]);
                return $create;
            });
            // Notify the assigned member about the new task.
            event(new NotifyToMemberTask(
                $create->id,
                $create->slug,
                $create->assigned_id,
                current_workspace()->id,
                current_workspace()->slug
            ));
            // Flash a success message to the session.
            session()->flash('success-message-create-task', __('Task created successfully'));
            // Return a success response to the client.
            return $this->returnData(['message' => __('Task created successfully')]);
        } catch (HttpResponseException $e) {
            return $e->getResponse();
        } catch (\Exception $e) {
            return $this->errorException(HttpStatusCode::INTERNAL_SERVER_ERROR->value, $e->getMessage());
        }
    }
    /**
     * Handle the delete request for a task.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|string
     * @throws HttpResponseException
     * @throws \Exception
     */
    public function delete(Request $request)
    {
        try {
            $id = $request->input('task_id');
            // Delete the task with the specified ID from the database.
            Tasks::where('id', $id)->delete();
            // Flash a success message to the session.
            session()->flash('success-message-delete-task', __('Task deleted successfully'));
            // Return a success response to the client.
            return $this->returnData(['message' => __('Task deleted successfully')]);
        } catch (DatabaseException $e) {
            return $this->errorException($e->getCode(), $e->getMessage());
        } catch (\Exception $e) {
            return $this->errorException(HttpStatusCode::INTERNAL_SERVER_ERROR->value, $e->getMessage());
        }
    }
}
