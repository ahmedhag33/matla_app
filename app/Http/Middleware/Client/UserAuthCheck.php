<?php

namespace App\Http\Middleware\Client;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserAuthCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            session()->flash('error-message-user', __('You must be logged in to access this page.'));
            // Redirect to the index page or any other appropriate page
            return redirect()->route('index-page');
        }
        return $next($request);
    }
}
