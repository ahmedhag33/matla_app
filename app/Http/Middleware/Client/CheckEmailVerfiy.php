<?php

namespace App\Http\Middleware\Client;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckEmailVerfiy
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && !auth()->user()->email_verified_at) {
            session()->flash('error-message-user-verify', __('You must verify your email address to access this page.'));
            // Redirect to the verification page
            return redirect()->route('verification-page');
        }
        return $next($request);
    }
}
