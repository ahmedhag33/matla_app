<?php

namespace App\Http\Middleware\DashBoard;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminPasswordIsChange
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->guard('admin')->check() && auth()->guard('admin')->user()->must_change_password == 1) {
            // If the admin is authenticated and has changed their password, redirect them to the dashboard
            session()->flash('error-admin-password-change', __('You have already changed your password'));
            // Redirect to the login page or any other appropriate route
            return redirect(route('dashboard.index'));
        }
        return $next($request);
    }
}
