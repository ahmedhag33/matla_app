<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkspacePermission extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'workspace_permissions';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'slug', 'name', 'parent_id'];
    /**
     * Get the parent permission of the current permission.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(WorkspacePermission::class, 'parent_id');
    }
    /**
     * Get the child permissions of the current permission.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(WorkspacePermission::class, 'parent_id');
    }
}
