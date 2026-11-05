<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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
     * Scope a query to only include members in the current workspace.
     *
     * @param  Builder $query
     * @return Builder
     */
    public function scopeInWorkspace(Builder $query)
    {
        return $query->whereHas('workspaces', function ($q) {
            $q->where('workspace_id', current_workspace()->id);
        });
    }
    /**
     * Scope a query to only include members not equal to the current user.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeNotEqualCurrentUser(Builder $query)
    {
        return $query->where('id', '!=', auth()->guard('member')->id());
    }
    /**
     * Scope a query to only include members in the program team.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeInProgramTeam(Builder $query, $program_id)
    {
        return $query->whereIn('id',ProgramTeam::where('program_id', $program_id)->pluck('team_member_id'));
    }
    /**
     * Scope a query to only include members not equal to the creators of workspaces.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeNotWorkspaceCreators(Builder $query)
    {
        return $query->whereNotIn('id', Workspace::where('created_by', auth()->guard('member')->user()->id)->pluck('created_by'));
    }
    /**
     * Scope a query to only include members with the specified role.
     *
     * @param  Builder $query
     * @param  string $role
     * @return Builder
     */
    public function scopeEqualRole(Builder $query, $role)
    {
        return $query->whereIn('workspace_role_id', function ($q) use ($role) {
            $q->select('id')
                ->from((new WorkspaceRoles())->getTable())
                ->where('slug', $role);
        });
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
        $workspacePermission = WorkspacePermission::where('slug', $slug)
            ->whereNull('parent_id')
            ->first();
        // If no main permission is found, return false
        if (!$workspacePermission) {
            return false;
        }
        // Get the role ID of the member
        $role = self::role()->first();
        // If no role is found, return false
        if (!$role) {
            return false;
        }
        // Get the workspace permission roles for the member's role and the specified main permission
        $workspacePermissionRoles = WorkspaceRolePermission::where('workspace_role_id', $role->id)
            ->whereIn(
                'workspace_permission_id',
                WorkspacePermission::where('parent_id', $workspacePermission->id)
                    ->pluck('id')
            )
            ->pluck('id')
            ->all();
        // If there are no workspace permission roles, return false
        if (count($workspacePermissionRoles) === 0) {
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
