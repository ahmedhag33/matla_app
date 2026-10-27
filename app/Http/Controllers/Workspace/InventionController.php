<?php

namespace App\Http\Controllers\Workspace;

use App\Http\Controllers\Controller;
use App\Http\Requests\Workspace\InventionRequest;
use App\Jobs\Workspace\InventionMemberJob;
use App\Models\WorkspaceInvitations;
use App\Models\WorkspaceRoles;
use App\Service\Base\JsonAPIMessages;
use App\Service\Enum\HttpStatusCode;
use Illuminate\Http\Exceptions\HttpResponseException;

class InventionController extends Controller
{
    use JsonAPIMessages;
    /**
     * show the index page for inventions
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $roles = WorkspaceRoles::notHighest()->get();
        // Fetch all workspace invitations with their related invitedBy and role models
        $inventions = WorkspaceInvitations::with(['invitedBy', 'role'])->get();
        // Pass the non-highest level roles to the view
        return view('workspace.invention.index', compact('roles', 'inventions'));
    }
    /**
     * store a new invention invitation
     *
     * @param  InventionRequest  $request
     * @return \Illuminate\Http\JsonResponse|string
     * @throws HttpResponseException
     * @throws \Exception
     */
    public function create(InventionRequest $request)
    {
        try {
            // Generate a token for the invitation if not already set
            $token = createToken(20);
            // Pass the generated token to the creation function
            $create = (object) runTransaction(function () use ($request, $token) {
                $create = WorkspaceInvitations::create([
                    'name' => $request->input('name'),
                    'workspace_role_id' => $request->input('role_id'),
                    'email' => $request->input('email'),
                    'token' => createHash($token),
                ]);
                return $create;
            });
            // Dispatch the job to send the invitation email
            dispatch(new InventionMemberJob(
                $create->email,
                $create->name,
                current_workspace()->name,
                route('workspace.auth.invention-register', ['token' => $token])
            ))->delay(now()->addSeconds(5));
            // Flash a success message to the session
            session()->flash('success-invention', __('New Invitation Created'));
            // Return the created invitation data
            return $this->returnData(['success' => true], HttpStatusCode::CREATED->value);
        } catch (HttpResponseException $e) {
            return $e->getResponse();
        } catch (\Exception $e) {
            return $this->errorException(HttpStatusCode::INTERNAL_SERVER_ERROR->value, $e->getMessage());
        }
    }
}
