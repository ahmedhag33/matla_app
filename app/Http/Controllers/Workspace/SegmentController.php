<?php

namespace App\Http\Controllers\Workspace;

use App\Exceptions\DatabaseException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Workspace\SegmentRequest;
use App\Http\Requests\Workspace\SegmentSortRequest;
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
    /**
     * Sort a segment by its new position.
     *
     * @param SegmentSortRequest $request
     * @return \Illuminate\Http\JsonResponse|string
     * @throws DatabaseException
     * @throws \Exception
     */

    public function sort(SegmentSortRequest $request)
    {
        try {
            // Get the segment ID and new position from the request
            $segmentId = $request->input('segments_id');
            // Get the new segment number from the request
            $segmentNumber = $request->input('segment_number');
            // Validate that both segment ID and segment number are provided
            if (!$segmentId || !$segmentNumber) {
                throw new DatabaseException(
                    __('Segment ID and segment number are required'),
                    HttpStatusCode::BAD_REQUEST->value
                );
            }
            // Run the transaction to update segment positions safely
            runTransaction(function () use ($segmentId, $segmentNumber) {
                $segment = Segments::lockForUpdate()->find($segmentId);
                // Lock the segment row for update to prevent race conditions
                if (!$segment) {
                    throw new DatabaseException(
                        __('Segment not found'),
                        HttpStatusCode::NOT_FOUND->value
                    );
                }
                // Store the old and new positions for later comparison
                $oldPosition = $segment->segment_number;
                $newPosition = (int) $segmentNumber;
                // Get the episode ID to adjust other segments within the same episode
                $episodeId = $segment->episode_id;
                // If the old and new positions are the same, no need to update
                if ($oldPosition == $newPosition) {
                    return;
                }
                // Get the maximum position for the episode to validate the new position
                $maxPosition = Segments::where('episode_id', $episodeId)
                    ->max('segment_number');
                // Validate the new position against the maximum position
                if ($newPosition < 1 || $newPosition > $maxPosition) {
                    throw new DatabaseException(
                        __('Invalid segment number'),
                        HttpStatusCode::BAD_REQUEST->value
                    );
                }
                // Move segment to temporary position to avoid conflicts with other segments
                $tempPosition = $maxPosition + 1;
                // Temporarily set the segment to a position outside the current range
                $segment->update([
                    'segment_number' => $tempPosition
                ]);
                // Adjust other segments positions
                if ($newPosition < $oldPosition) {
                    Segments::where('episode_id', $episodeId)
                        ->whereBetween('segment_number', [
                            $newPosition,
                            $oldPosition - 1
                        ])
                        ->increment('segment_number');
                } else {
                    Segments::where('episode_id', $episodeId)
                        ->whereBetween('segment_number', [
                            $oldPosition + 1,
                            $newPosition
                        ])
                        ->decrement('segment_number');
                }
                // Set the final position
                $segment->update([
                    'segment_number' => $newPosition
                ]);
                logger()->info('Segment Updated', [
                    'id' => $segment->id,
                    'old_position' => $oldPosition,
                    'new_position' => $newPosition,
                    'database_position' => $segment->fresh()->segment_number,
                ]);
            });
            // Return success response after sorting segments successfully
            return $this->returnData([
                'success' => true,
                'message' => __('Segment sorted successfully')
            ], HttpStatusCode::CREATED->value);

        } catch (HttpResponseException $e) {
            return $e->getResponse();
        } catch (DatabaseException $e) {
            return $this->errorException($e->getCode(), $e->getMessage());
        } catch (\Exception $e) {
            return $this->errorException(
                HttpStatusCode::INTERNAL_SERVER_ERROR->value,
                $e->getMessage()
            );
        }
    }
}
