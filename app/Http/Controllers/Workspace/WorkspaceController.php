<?php

namespace App\Http\Controllers\Workspace;

use App\Http\Controllers\Controller;
use App\Http\Requests\Workspace\WorkspaceStepRequest;
use App\Models\Country;
use App\Models\WorkspaceType;
use App\Service\Base\JsonAPIMessages;
use Illuminate\Http\Exceptions\HttpResponseException;

class WorkspaceController extends Controller
{
    use JsonAPIMessages;
    /**
     * show create workspace page
     *
     * @return \Illuminate\View\View
     */
    public function createPage()
    {
        // select all workspace types
        $workspaceTypes = WorkspaceType::all();
        // select all countries
        $countries = Country::all();
        // return view
        return view('membership.workspace.create', compact('workspaceTypes', 'countries'));
    }
    /**
     * handle workspace step
     *
     * @param WorkspaceStepRequest $request
     * @param int $step
     * @return \Illuminate\Http\JsonResponse|string
     * @throws HttpResponseException
     */
    public function step(WorkspaceStepRequest $request, int $step)
    {
        try {
            return response()->json(['step' => $step, 'data' => $request->validated()]);
        } catch (HttpResponseException $e) {
            return $e->getResponse();
        } catch (\Exception $e) {
            return $this->errorException($e->getCode(), __('An error occurred'));
        }
    }
}
