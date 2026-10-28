<?php

namespace App\Http\Controllers\Workspace;

use App\Events\Workspace\NotfiyAcceptToWorkspace;
use App\Http\Controllers\Controller;
use App\Models\Workspace;
use App\Models\WorkspaceInvitations;
use App\Models\WorkspaceMembers;
use App\Service\Auth\Member\LoginAuthService;
use App\Service\Base\JsonAPIMessages;
use App\Service\Enum\HttpStatusCode;
use App\Service\Enum\WorkspaceStatus;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    use JsonAPIMessages;
    /**
     * var LoginAuthService
     *
     * @var LoginAuthService */
    protected ?LoginAuthService $loginAuthService;
    /**
     * Create a new controller instance.
     *
     * @param LoginAuthService $loginAuthService
     */
    public function __construct(LoginAuthService $loginAuthService)
    {
        $this->loginAuthService = $loginAuthService;
    }
    /**
     *  Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $inventions = WorkspaceInvitations::with('workspace')->whereNull('accepted_at')
            ->where('email', auth()->guard('member')->user()->email)
            ->where('status', 'pending')
            ->get();
        // Fetch all pending workspace invitations for the current member's email
        return view('membership.index', compact('inventions'));
    }
    /**
     * Accept a workspace invitation.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function acceptInvitation(Request $request)
    {
        try {
            $workspaceId = $request->input('workspace_id');
            // get the workspace by ID
            $workspace = Workspace::find($workspaceId);
            // Find the pending invitation for the given workspace and current member's email
            $invitation = WorkspaceInvitations::where('workspace_id', $workspaceId)
                ->where('email', auth()->guard('member')->user()->email)
                ->where('status', 'pending')
                ->whereNull('accepted_at')
                ->first();
            // Run the transaction to update the invitation status
            $create = (object) runTransaction(function () use ($invitation, $workspaceId) {
                $invitation->update([
                    'accepted_at' => now(),
                    'status' => WorkspaceStatus::ACCEPTED->value
                ]);
                $create = WorkspaceMembers::create(['workspace_id' => $workspaceId]);
                // Return the created workspace member instance
                return $create;
            });
            // Notify the workspace creator that the invitation has been accepted
            event(new NotfiyAcceptToWorkspace(
                $workspaceId,
                $workspace->created_by,
                auth()->guard('member')->user()->id,
                $create->id,
                route('workspace.invention.index', ['slug' => $workspace->slug])
            ));
            // Flash a success message to the session
            session()->flash('success-message-accept-invitation', __('Invitation accepted successfully.'));
            // Return the response with the success message and redirect URL
            return $this->returnData([
                'message' => __('Invitation accepted successfully.'),
                'url' => route('workspace.dashboard.index', ['slug' => $workspace->slug])
            ], HttpStatusCode::CREATED->value);
        } catch (\Exception $e) {
            return $this->errorException(HttpStatusCode::INTERNAL_SERVER_ERROR->value, $e->getMessage());
        }
    }

    /**
     * logout user from the system
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        return $this->loginAuthService->logout();
    }
}
