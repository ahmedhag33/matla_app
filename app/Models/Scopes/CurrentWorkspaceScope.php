<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class CurrentWorkspaceScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param Builder $builder
     * @param Model $model
     *
     * @return void
     */
    public function apply(Builder $builder, Model $model): void
    {
        // Check if the current workspace is bound in the application container
        if (app()->bound('current_workspace')) {
            // Retrieve the current workspace instance from the application container
            $currentWorkspace = app('current_workspace');
            // Apply the current workspace filter to the query
            $builder->where('workspace_id', $currentWorkspace->id);
        }
    }
}
