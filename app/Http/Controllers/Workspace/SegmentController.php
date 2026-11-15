<?php

namespace App\Http\Controllers\Workspace;

use App\Exceptions\DatabaseException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Workspace\SegmentRequest;
use App\Models\Episode;
use App\Models\Segments;
use App\Service\Base\JsonAPIMessages;
use App\Service\Enum\HttpStatusCode;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class SegmentController extends Controller
{
    use JsonAPIMessages;
    /**
     * Create or update a segment for an episode.
     *
     * @param SegmentRequest $request
     * @return \Illuminate\Http\JsonResponse|string
     * @throws HttpResponseException
     * @throws \Exception
     */
    public function createOrUpdate(SegmentRequest $request)
    {
        try {
            $episodeId = $request->input('episode_id');
            // Find the episode by ID, or fail if it doesn't exist
            $episode = Episode::findOrFail($episodeId);
            // Run the transaction to create or update the segment
            runTransaction(function () use ($request, $episode) {
                $segmentId = $request->input('segment_id');
                // Check if segment ID is provided to determine create or update operation
                if ($segmentId) {
                    $segment = $episode->segments()->findOrFail($segmentId);
                    // Update the existing segment with the provided data
                    $segment->update([
                        'title' => $request->input('title'),
                        'type' => $request->input('type'),
                        'duration' => $request->input('duration'),
                        'description' => $request->input('description'),
                    ]);
                } else {
                    $segment = $episode->segments()->create([
                        'title' => $request->input('title'),
                        'type' => $request->input('type'),
                        'duration' => $request->input('duration'),
                        'description' => $request->input('description'),
                    ]);
                }
            });
            session()->flash('success-message-segment', ($request->input('segment_id') ? __('Segment updated successfully') : __('Segment created successfully')));
            // Flash a success message to the session for the segment operation
            return $this->returnData([
                'error' => false,
                'message' => ($request->input('segment_id') ? __('Segment updated successfully') : __('Segment created successfully')),
                'url' => routeWorkspace('workspace.episode.details', ['episodeSlug' => $episode->slug])
            ], HttpStatusCode::CREATED->value);
        } catch (HttpResponseException $e) {
            return $e->getResponse();
        } catch (\Exception $e) {
            return $this->errorException(HttpStatusCode::INTERNAL_SERVER_ERROR->value, $e->getMessage());
        }
    }
    /**
     * Get a segment by its ID.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws DatabaseException
     * @throws \Exception
     */
    public function getById(Request $request)
    {
        try {
            $segmentId = $request->input('segment_id');
            // Validate that the segment ID is provided
            if (!$segmentId) {
                return $this->errorException(HttpStatusCode::BAD_REQUEST->value, __('Segment ID is required'));
            }
            // Retrieve the segment by ID
            $segment = Segments::find($segmentId);
            // Check if the segment exists
            if (!$segment) {
                throw new DatabaseException(__('Segment not found'), HttpStatusCode::NOT_FOUND->value);
            }
            return $this->returnData([
                'error' => false,
                'data' => $segment
            ], HttpStatusCode::OK->value);
        } catch (DatabaseException $e) {
            return $this->errorException($e->getCode(), $e->getMessage());
        } catch (\Exception $e) {
            return $this->errorException(HttpStatusCode::INTERNAL_SERVER_ERROR->value, $e->getMessage());
        }
    }
    /**
     * Delete a segment by its ID.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws DatabaseException
     * @throws \Exception
     */
    public function delete(Request $request)
    {
        try {
            // Get the segment ID from the request
            $segmentId = $request->input('segment_id');
            // Validate that the segment ID is provided
            if (!$segmentId) {
                return $this->errorException(HttpStatusCode::BAD_REQUEST->value, __('Segment ID is required'));
            }
            // Retrieve the segment by ID
            $segment = Segments::find($segmentId);
            // Check if the segment exists
            if (!$segment) {
                throw new DatabaseException(__('Segment not found'), HttpStatusCode::NOT_FOUND->value);
            }
            // Delete the segment
            $segment->delete();
            // Return success response
            return $this->returnData([
                'error' => false,
                'message' => __('Segment deleted successfully')
            ], HttpStatusCode::OK->value);
        } catch (DatabaseException $e) {
            return $this->errorException($e->getCode(), $e->getMessage());
        } catch (\Exception $e) {
            return $this->errorException(HttpStatusCode::INTERNAL_SERVER_ERROR->value, $e->getMessage());
        }
    }
}
