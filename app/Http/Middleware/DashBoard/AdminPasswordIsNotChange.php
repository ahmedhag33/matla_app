<?php

namespace App\Http\Middleware\DashBoard;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminPasswordIsNotChange
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->guard('admin')->check() && auth()->guard('admin')->user()->must_change_password == 0) {
            // If the admin is authenticated and has not changed their password, redirect them to the recover password page
            session()->flash('error-admin-password-not-change', __('You must change your password before continuing'));
            // Redirect to the login page or any other appropriate route
            return redirect(route('dashboard.auth.recover-password'));
        }
        return $next($request);
    }
}
