<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkspacePermission extends Model
{
    use SoftDeletes;
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
    protected $fillable = [
        'id',
        'slug',
        'name',
        'parent_id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
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
    /**
     * Scope a query to only include permissions without a parent.
     *
     * @param  Builder $query
     * @return Builder
     */
    public function scopePermissionIsNull(Builder $query)
    {
        return $query->whereNull('parent_id');
    }
}
