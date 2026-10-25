<?php

namespace App\Models;

use App\Models\Scopes\CurrentWorkspaceScope;
use App\Service\Enum\WorkspaceStatus;
use App\Service\Layouts\GenralStatus;
use Illuminate\Database\Eloquent\Model;

class WorkspaceInvitations extends Model
{
    use GenralStatus;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'workspace_invitations';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'workspace_role_id',
        'token',
        'expires_at',
        'accepted_at',
        'invited_by',
        'status',
        'workspace_id'
    ];
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        parent::booted();
        // Automatically generate a token when creating a new invitation
        static::creating(function ($workspaceInvitions) {
            // Generate a token for the invitation if not already set
            $workspaceInvitions->token = createToken(8);
            // Set the expiration date for the invitation
            $workspaceInvitions->expires_at = now()->addDays(7);
            // Set the invited_by field if the user is authenticated as a member
            if (auth()->guard('member')->check()) {
                $workspaceInvitions->invited_by = auth()->guard('member')->id;
            }
        });
        // Apply the current workspace scope to all queries
        static::addGlobalScope(new CurrentWorkspaceScope());
    }
    /**
     * Get the role associated with the invitation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(WorkspaceRoles::class, 'workspace_role_id');
    }
    /**
     * Get the member who invited the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function invitedBy()
    {
        return $this->belongsTo(Member::class, 'invited_by');
    }
    /**
     * Get the workspace associated with the invitation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function workspace()
    {
        return $this->belongsTo(Workspace::class, 'workspace_id');
    }
    /**
     * Get the status badge color for the invitation status.
     *
     * @param  string  $value
     * @return string
     */
    public function getStatusAttribute($value)
    {
        return match ($value) {
            WorkspaceStatus::PENDING->value => $this->span('warning', $value),
            WorkspaceStatus::ACCEPTED->value => $this->span('success', $value),
            WorkspaceStatus::EXPIRED->value => $this->span('danger', $value),
            default => $this->span('secondary', $value),
        };
    }
}
