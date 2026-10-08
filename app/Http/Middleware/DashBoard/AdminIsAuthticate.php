<?php

namespace App\Http\Middleware\DashBoard;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminIsAuthticate
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->guard('admin')->check()) {
            session()->flash('error-admin-is-authticate', __('You are already logged in'));
            // Redirect to the login page or any other appropriate route
            return redirect(route('dashboard.index'));
        }
        return $next($request);
    }
}
