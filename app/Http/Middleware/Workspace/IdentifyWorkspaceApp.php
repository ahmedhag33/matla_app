<?php

namespace App\Http\Middleware\Workspace;

use App\Models\Workspace;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IdentifyWorkspaceApp
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $slug = $request->route('slug');
        // If slug is not provided, abort with 404
        if (!$slug) {
            abort(404, 'slug not found');
        }
        // Fetch the workspace based on the slug
        $workspace = Workspace::where('slug', $slug)->first();
        // If workspace is not found, abort with 404
        if (!$workspace) {
            abort(404, 'workspace not found');
        }
        // Register the workspace instance in the application container
        app()->instance('current_workspace', $workspace);
        // register the workspace instance in the application container under the key 'current_workspace'
        return $next($request);
    }
}
