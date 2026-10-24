<?php

namespace App\Http\Middleware\Workspace;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMemberWorkspace
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //get the workspace slug from the route
        $slug = $request->route('slug');
        // Check if the user is a member of the workspace
        $user = auth()->guard('member')->user();
        // Check if the user has access to the workspace with the given slug
        $hasAccess = $user->workspaces()->where('slug', $slug)->exists();
        // If the user does not have access, abort with a 403 error
        if (!$hasAccess) {
           session()->flash('error-message-workspace-member', __('You do not have access to this workspace'));
           // Redirect the user to the workspace member index page
           return redirect(route('workspace.member.index'));
        }
        return $next($request);
    }
}
