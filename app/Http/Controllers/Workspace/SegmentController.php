<?php

namespace App\Http\Controllers\Workspace;

use App\Http\Controllers\Controller;
use App\Http\Requests\Workspace\SegmentRequest;
use App\Models\Episode;
use App\Service\Base\JsonAPIMessages;
use App\Service\Enum\HttpStatusCode;
use Illuminate\Http\Exceptions\HttpResponseException;

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
}
