<?php

namespace App\Http\Controllers\Workspace;

use App\Http\Controllers\Controller;
use App\Http\Requests\Workspace\StoreWorkspaceRequest;
use App\Http\Requests\Workspace\WorkspaceStepRequest;
use App\Models\Country;
use App\Models\Workspace;
use App\Models\WorkspaceMembers;
use App\Models\WorkspaceType;
use App\Service\Base\JsonAPIMessages;
use App\Service\Enum\HttpStatusCode;
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
    /**
     * store workspace
     *
     * @param StoreWorkspaceRequest $request
     * @return \Illuminate\Http\JsonResponse|string
     * @throws HttpResponseException
     * @throws \Exception
     */
    public function store(StoreWorkspaceRequest $request)
    {
        try {
            (object) runTransaction(function () use ($request) {
                $create = Workspace::create([
                    'name' => $request->input('name'),
                    'description' => $request->input('description'),
                    'workspace_type_id' => $request->input('workspace_type_id'),
                    'country_id' => $request->input('country_id'),
                ]);
                WorkspaceMembers::create(['workspace_id' => $create->id]);
            });
            // flash success message to session
            session()->flash('create-workspace-success', __('Workspace created successfully'));
            // return json response with redirect URL
            return $this->returnData(['url' => route('workspace.member.index'), 'message' => __('Workspace created successfully')], HttpStatusCode::CREATED->value);
        } catch (HttpResponseException $e) {
            return $e->getResponse();
        } catch (\Exception $e) {
            return $this->errorException(HttpStatusCode::INTERNAL_SERVER_ERROR->value, $e->getMessage());
        }
    }
}
