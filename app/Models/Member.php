<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\WorkspacePermission;
use App\Models\WorkspaceRolePermission;

class Member extends Authenticatable
{
    use Notifiable;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'members';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'slug',
        'password',
        'phone',
        'address',
        'photo',
        'workspace_role_id',
        'email_verified_at',
        'remember_token',
        'created_at',
        'updated_at'
    ];
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        // create slug from name when creating a new member
        static::creating(function ($member) {
            $member->slug = str()->slug($member->name);
        });
    }
    /**
     *  Get the role that the member belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(WorkspaceRoles::class, 'workspace_role_id');
    }
    /**
     * Get the verfication codes for the member.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function verfication_codes()
    {
        return $this->hasMany(MemberVerficationCodes::class, 'member_id');
    }
    /**
     * Get the workspaces that the member belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function workspaces()
    {
        return $this->belongsToMany(
            Workspace::class,
            new WorkspaceMembers()->getTable(),
            'member_id',
            'workspace_id'
        );
    }
    /**
     * Get the notifications for the member.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notification()
    {
        return $this->hasMany(WorkspaceNotification::class, 'member_id');
    }
    /**
     * Check if the member has the specified permission.
     *
     * @param string $slug
     * @return bool
     */
    public function hasPermission($slug)
    {
        $workspacePermission = WorkspacePermission::where('slug', $slug)->first()->id;
        // Get the role ID of the member
        $role_id = self::role()->first()->id;
        // Check if the role has the specified permission
        return WorkspaceRolePermission::where('workspace_role_id', $role_id)
            ->where('workspace_permission_id', $workspacePermission)
            ->exists();
    }
    /**
     * Check if the member has the specified main permission.
     *
     * @param string $slug
     * @return bool
     */
    public function hasMainPermission($slug)
    {
        $workspacePermission = WorkspacePermission::where('slug', $slug)->whereNull('parent_id')->first()->id;
        // Get the role ID of the member
        $role_id = self::role()->first()->id;
        // Get the workspace permission roles for the member's role and the specified main permission
        $workspacePermissionRoles = WorkspaceRolePermission::where('workspace_role_id', $role_id)
            ->where('workspace_permission_id', $workspacePermission)
            ->whereIn('workspace_permission_id', WorkspacePermission::where('parent_id', $workspacePermission)->pluck('id'))
            ->pluck('id')->all();
        // If there are no workspace permission roles, return false
        if (!is_countable($workspacePermissionRoles) && count($workspacePermissionRoles) === 0) {
            return false;
        }
        // If there are workspace permission roles, return true
        return true;
    }
    /**
     * Get the unread notifications for the member in the current workspace.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function showNotifications($isworkspace = false)
    {
        $query = $this->notification()->with('notifyBy')->orderBy('created_at', 'desc')->whereNull('read_at');
        // check if we need to filter by workspace
        if ($isworkspace === true) {
            $query->where('workspace_id', current_workspace()->id);
        }
        return $query->get();
    }
}
