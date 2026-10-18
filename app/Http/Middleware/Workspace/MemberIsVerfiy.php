<?php

namespace App\Http\Middleware\Workspace;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MemberIsVerfiy
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->guard('member')->check() && auth()->guard('member')->user()->email_verified_at) {
            session()->flash('error-message-user-verify', __('You must verify your email address to access this page.'));
            // Store the intended URL in the session
            session()->put('url.intended', $request->fullUrl());
            // Redirect to the verification page
            return redirect(session()->get('url.intended') ?? route('workspace.member.index'));
        }
        return $next($request);
    }
}
