<?php

namespace App\Models;

use App\Models\Querys\CanByMember;
use App\Models\Scopes\CurrentWorkspaceScope;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class WorkspaceNotification extends Model
{
    use CanByMember;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'workspace_notifications';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'member_id',
        'workspace_id',
        'notification_type',
        'notification_id',
        'title',
        'message',
        'data',
        'read_at',
        'notify_by',
        'created_at',
        'updated_at'
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'array',
    ];
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        parent::booted();
        /* Automatically set member_id to the currently authenticated member's ID if available
         * This will ensure that the member_id is always set when creating a new workspace notification.
         */
        static::creating(function ($workspaceNotification) {
            // Set member_id to the currently authenticated member's ID if available
            if (auth()->guard('member')->check()) {
                // Set the member_id to the currently authenticated member's ID
                $workspaceNotification->notify_by = auth()->guard('member')->user()->id;
            }
        });
        // Apply the current workspace scope to all queries
        static::addGlobalScope(new CurrentWorkspaceScope());
    }
    /**
     * Get the read_at attribute value.
     *
     * @return Attribute
     */
    public function readAtFormatted(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->read_at ? dateFormat($this->read_at) . ' ' . timeFormat($this->read_at) : null,
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
     * Get the member that owns the notification.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
    /**
     * Get the workspace that owns the notification.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function workspace()
    {
        return $this->belongsTo(Workspace::class, 'workspace_id');
    }
    /**
     * Get the member who notified.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function notifyBy()
    {
        return $this->belongsTo(Member::class, 'notify_by');
    }
    /**
     * Get the notification model associated with the workspace notification.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function notification()
    {
        return $this->morphTo();
    }
}
