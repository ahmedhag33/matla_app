<?php

namespace App\Http\Middleware\Workspace;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MemberIsNotVerfiy
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->guard('member')->check() && !auth()->guard('member')->user()->email_verified_at) {
            session()->flash('error-message-user-verify', __('You must verify your email address to access this page.'));
            // Redirect to the verification page
            return redirect(route('workspace.verification.index'));
        }
        return $next($request);
    }
}
