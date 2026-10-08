<?php

namespace App\Http\Middleware\Client;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirctedIfVerfiy
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->email_verified_at) {
            session()->flash('error-message-user-if-verify', __('You have already verified your email address. You cannot access the verification page.'));
            // Redirect to the verification page
            return redirect()->route('user-page');
        }
        return $next($request);
    }
}
