<?php

namespace App\Http\Middleware\Workspace;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureVerificationCodeSent
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->session()->has('verification_email')) {
            session()->flash('error-message-user-verify', __('You must verify your email address to access this page.'));
            // get forget password
            return redirect()->route('workspace.auth.forget-password');
        }
        return $next($request);
    }
}
