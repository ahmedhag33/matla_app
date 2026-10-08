<?php

namespace App\Http\Middleware\Client;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserISVerify
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && !auth()->user()->email_verified_at) {
            // Flash a message to the session
            session()->flash('error-message-user-verify', __('You must verify your email address to access this page.'));
            // Store the intended URL in the session
            session()->put('url.intended', $request->fullUrl());
            // Redirect to the verification page
            return redirect()->route('index-page', ['is_verify' => 0]);
        }
        return $next($request);
    }
}
