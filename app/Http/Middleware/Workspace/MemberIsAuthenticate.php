<?php

namespace App\Http\Middleware\Workspace;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MemberIsAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->guard('member')->check()) {
            // Flash a message to the session
            session()->flash('auth-member-message', __('You are already logged in'));
            // Store the intended URL in the session
            session()->put('url.intended', $request->fullUrl());
            // Redirect to the login page or any other appropriate route
            return redirect(route('workspace.member.index'));
        }
        return $next($request);
    }
}
