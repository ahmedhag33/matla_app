<?php

namespace App\Http\Middleware\Workspace;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CkeckMemberInProgramTeam
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->guard('member')->user()->checkInProgramTeam($request->route('programSlug'))) {
            session()->flash('error-message-part-team', __('You are not part of this program team.'));
            // Redirect back with an error message if the user is not part of the program team
            return redirect()->back();
        }
        return $next($request);
    }
}
