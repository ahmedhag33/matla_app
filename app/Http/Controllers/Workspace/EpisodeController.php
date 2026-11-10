<?php

namespace App\Http\Controllers\Workspace;

use App\Http\Controllers\Controller;
use App\Http\Requests\Workspace\EpisodeRequest;
use App\Service\Base\JsonAPIMessages;
use App\Service\Enum\HttpStatusCode;
use Illuminate\Http\Exceptions\HttpResponseException;
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
}
