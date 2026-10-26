<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkspaceRoles extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'workspace_roles';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'name_en',
        'slug',
        'level',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        parent::booted();
        // Automatically generate slug when creating a new workspace role
        static::creating(function ($workspaceRole) {
            // Generate slug from name
            $workspaceRole->slug = str()->slug($workspaceRole->name_en);
        });
    }
    /**
     * Get the permissions that belong to the role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permission()
    {
        return $this->belongsToMany(
            WorkspacePermission::class,
            new WorkspaceRolePermission()->getTable(),
            'role_id',
            'permission_id'
        );
    }
    /**
     * Get the members that belong to the role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function member()
    {
        return $this->hasMany(Member::class, 'workspace_role_id');
    }
    /**
     * Scope a query to only include highest level roles.
     *
     * @param  Builder $query
     * @return Builder
     */
    public function scopeHighest(Builder $query)
    {
        return $query->where('level', 1);
    }
    /**
     * Scope a query to only include non-highest level roles.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeNotHighest(Builder $query)
    {
        return $query->where('level', '!=', 1);
    }
}
