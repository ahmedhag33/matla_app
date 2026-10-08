<?php

namespace App\Http\Middleware\DashBoard;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminIsAuthticate
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->guard('admin')->check()) {
            session()->flash('error-admin-message', __('You are not authorized to access this page. Please log in as an admin.'));
            // Redirect to the login page or any other appropriate route
            return redirect(route('dashboard.auth.login'));
        }
        return $next($request);
    }
}
