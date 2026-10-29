<?php

namespace App\Models;

use App\Models\Scopes\CurrentWorkspaceScope;
use App\Service\Enum\BroadcastMode;
use App\Service\Enum\BroadcastSchedule;
use App\Service\Enum\ProgramStatus;
use App\Service\Layouts\GenralStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use GenralStatus;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'programs';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'slug',
        'icon',
        'description',
        'is_active',
        'program_type_id',
        'broadcast_mode',
        'broadcast_schedule',
        'default_duration_minutes',
        'status',
        'workspace_id',
        'created_by',
        'created_at',
        'updated_at'
    ];
    /**
     * Apply the current workspace scope to all queries for this model.
     *
     * @return void
     */
    protected static function booted()
    {
        parent::booted();
        // Apply the current workspace scope to all queries for this model.
        static::addGlobalScope(new CurrentWorkspaceScope());
    }
    /**
     * Get the program type associated with the program.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function programType()
    {
        return $this->belongsTo(ProgramTypes::class, 'program_type_id');
    }
    /**
     * Get the workspace associated with the program.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function workspace()
    {
        return $this->belongsTo(Workspace::class, 'workspace_id');
    }
    /**
     * Get the member who created the program.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo(Member::class, 'created_by');
    }
    /**
     * Get the presenters associated with the program.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function presenters()
    {
        return $this->belongsToMany(Member::class, 'program_presenters', 'program_id', 'presenter_id');
    }
    /**
     * Interact with the broadcast_mode attribute.
     *
     * @return Attribute
     */
    public function broadcastModeAttribute(): Attribute
    {
        return Attribute::make(
            get: fn() => match ($this->broadcast_mode) {
                BroadcastMode::LIVE->value => $this->span('secondary', __('live')),
                BroadcastMode::RECORDED->value => $this->span('info', __('recorded')),
                default => 'unknown',
            },
        );
    }
    /**
     * Interact with the status attribute.
     *
     * @return Attribute
     */
    public function statusAttribute(): Attribute
    {
        return Attribute::make(
            get: fn() => match ($this->status) {
                ProgramStatus::PENDING->value => $this->span('warning', __('pending')),
                ProgramStatus::ACTIVE->value => $this->span('success', __('active')),
                ProgramStatus::INACTIVE->value => $this->span('danger', __('inactive')),
                default => 'unknown',
            },
        );
    }
    /**
     * Interact with the BroadcastSchedule attribute.
     *
     * @return Attribute
     */
    public function broadcastScheduleAttribute(): Attribute
    {
        return Attribute::make(
            get: fn() => match ($this->broadcast_schedule) {
                BroadcastSchedule::DAILY->value => __('daily'),
                BroadcastSchedule::WEEKLY->value => __('scheduled'),
                BroadcastSchedule::MONTHLY->value => __('monthly'),
                default => 'unknown',
            },
        );
    }
}
