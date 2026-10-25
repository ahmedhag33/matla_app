<?php

namespace App\Http\Middleware\Workspace;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMemberPermmision
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission): Response
    {
        if (!auth()->guard('member')->user()->hasPermission($permission)) {
            // flash error message to session
            session()->flash('error-message-permission', __('You do not have permission to perform this action.'));
            // redirect back to the previous page
            return redirect()->back();
        }
        return $next($request);
    }
}
