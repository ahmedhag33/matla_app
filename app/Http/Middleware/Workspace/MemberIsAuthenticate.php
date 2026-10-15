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
            session()->flash('auth-member-message', __('You are not authorized to access this page. Please log in as a member.'));
            // Redirect to the login page or any other appropriate route
            return redirect(session()->get('url.intended') ?? route('workspace.member.index'));
        }
        return $next($request);
    }
}
