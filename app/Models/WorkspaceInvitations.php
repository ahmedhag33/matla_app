<?php

namespace App\Models;

use App\Models\Scopes\CurrentWorkspaceScope;
use App\Service\Database\LogsActivity;
use App\Service\Enum\Crud;
use App\Service\Enum\WorkspaceStatus;
use App\Service\Layouts\GenralStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class WorkspaceInvitations extends Model
{
    use GenralStatus, LogsActivity;
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
     * Get a custom description for an activity log entry.
     *
     * Default hook that returns null, meaning no custom description.
     * Override it in a model to return a readable message for a given
     * action (e.g. "created", "updated", "deleted").
     *
     * @param  string  $action  The action being logged.
     * @return string|null      The description, or null to use none.
     */
    protected function getActivityDescription(string $action): ?string
    {
        return match ($action) {
            Crud::CREATE->value => __('New Invitation Created'),
            Crud::UPDATE->value => __('Invitation Updated'),
            Crud::DELETE->value => __('Invitation Deleted'),
            default => '---',
        };
    }
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
            // Set the expiration date for the invitation
            $workspaceInvitions->expires_at = now()->addDays(7);
            // Set the invited_by field if the user is authenticated as a member
            if (auth()->guard('member')->check()) {
                $workspaceInvitions->invited_by = auth()->guard('member')->user()->id;
            }
            // Set the workspace_id field to the current workspace's ID
            $workspaceInvitions->workspace_id = current_workspace()->id;
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
     * Interact with the  attribute for the formatted status.
     *
     * @return Attribute
     */
    public function statusFormatted(): Attribute
    {
        return Attribute::make(
            get: fn() => match ($this->status instanceof WorkspaceStatus
            ? $this->status->value
            : $this->status) {
                WorkspaceStatus::PENDING->value =>
                    $this->span('warning', __('Pending')),

                WorkspaceStatus::ACCEPTED->value =>
                    $this->span('success', __('Accepted')),

                WorkspaceStatus::EXPIRED->value =>
                    $this->span('danger', __('Expired')),

                default =>
                    $this->span('secondary', __('Unknown')),
            },
        );
    }
    /**
     * Get the created_at attribute value.
     *
     * @return Attribute
     */
    public function createdAtFormatted(): Attribute
    {
        return Attribute::make(
            get: fn() => dateFormat($this->created_at)
                . ' ' . timeFormat($this->created_at),
        );
    }
    /**
     * Get the updated_at attribute value.
     *
     * @return Attribute
     */
    public function updatedAtFormatted(): Attribute
    {
        return Attribute::make(
            get: fn() => dateFormat($this->updated_at)
                . ' ' . timeFormat($this->updated_at),
        );
    }
    /**
     * Get the expires_at attribute value.
     *
     * @return Attribute
     */
    public function expiresAtFormatted(): Attribute
    {
        return Attribute::make(
            get: fn() => dateFormat($this->expires_at)
                . ' ' . timeFormat($this->expires_at),
        );
    }
    /**
     * Get the accepted_at attribute value.
     *
     * @return Attribute
     */
    public function acceptedAtFormatted(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->accepted_at === null
                ? '-'
                : dateFormat($this->accepted_at)
                . ' ' . timeFormat($this->accepted_at),
        );
    }
}
