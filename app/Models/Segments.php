<?php

namespace App\Models;

use App\Service\Database\LogsActivity;
use App\Service\Enum\Crud;
use App\Service\Enum\SegmentStatus;
use App\Service\Enum\SegmentType;
use App\Service\Layouts\GenralStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Segments extends Model
{
    use GenralStatus, LogsActivity;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'segments';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'slug',
        'type',
        'segment_number',
        'duration',
        'episode_id',
        'created_by',
        'status',
        'is_active',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
        'duration' => 'integer',
        'segment_number' => 'integer',
    ];
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['type_to_string', 'status_to_string'];
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
            Crud::CREATE->value => __('New Segment Created'),
            Crud::UPDATE->value => __('Segment Updated'),
            Crud::DELETE->value => __('Segment Deleted'),
            default => null,
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
        // Automatically set the creator when creating a segment.
        static::creating(function ($segment) {
            // Set the creator if a member is authenticated.
            if (auth()->guard('member')->check()) {
                $segment->created_by = auth()->guard('member')->user()->id;
            }
            // Set the next segment number if not provided.
            if (empty($segment->segment_number)) {
                $segment->segment_number = $segment->lastSegmentNumber();
            }
            // Automatically generate a slug from the title if not provided.
            if (empty($segment->slug)) {
                $segment->slug = str()->slug($segment->title) . uniqid();
            }
        });
    }
    /**
     * Get the next segment number for the episode.
     *
     * @return int
     */
    protected function lastSegmentNumber()
    {
        return self::where('episode_id', $this->episode_id)->max('segment_number') + 1 ?? 1;
    }
    /**
     * Get the episode that owns the segment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function episode()
    {
        return $this->belongsTo(Episode::class, 'episode_id');
    }
    /**
     * Get the user who created the segment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(Member::class, 'created_by');
    }
    /**
     * Interact with the type to attribute.
     *
     * @return Attribute
     */
    public function typeToString(): Attribute
    {
        return Attribute::make(
            get: fn() => match ($this->type) {
                SegmentType::OPENING->value => $this->span('light', __('opening')),
                SegmentType::NEWS->value => $this->span('info', __('news')),
                SegmentType::REPORT->value => $this->span('secondary', __('report')),
                SegmentType::ANALYSIS->value => $this->span('primary', __('analysis')),
                SegmentType::INTERVIEW->value => $this->span('success', __('interview')),
                SegmentType::LIVE_CALL->value => $this->span('warning', __('live_call')),
                SegmentType::STATISTICS->value => $this->span('dark', __('statistics')),
                SegmentType::BREAK ->value => $this->span('secondary', __('break')),
                SegmentType::CLOSING->value => $this->span('danger', __('closing')),
                default => 'unknown',
            },
        );
    }
    /**
     * Interact with the statusToString attribute.
     *
     * @return Attribute
     */
    public function statusToString(): Attribute
    {
        return Attribute::make(
            get: fn() => match ($this->status) {
                SegmentStatus::DRAFT->value => $this->span('secondary', __('draft')),
                SegmentStatus::IN_PROGRESS->value => $this->span('info', __('in_progress')),
                SegmentStatus::READY->value => $this->span('primary', __('ready')),
                SegmentStatus::ARCHIVED->value => $this->span('dark', __('archived')),
                default => 'unknown',
            },
        );
    }
}
