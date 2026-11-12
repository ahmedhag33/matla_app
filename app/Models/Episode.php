<?php

namespace App\Models;

use App\Service\Database\LogsActivity;
use App\Service\Enum\Crud;
use App\Service\Enum\EpisodeStatus;
use App\Service\Layouts\GenralStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    use GenralStatus, LogsActivity;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'episodes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'program_id',
        'episode_number',
        'title',
        'description',
        'slug',
        'air_at',
        'duration',
        'reminder_before_air',
        'reminder_at',
        'status',
        'completed_percentage',
        'is_active',
        'created_by',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'air_at' => 'datetime',
        'reminder_at' => 'datetime',
    ];
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'air_at_formatted',
        'air_date_to_arabic_in_input',
        'air_time_to_arabic_in_input',
        'reminder_at_formatted',
        'duration_to_string',
        'duration_between_air_and_reminder',
        'duration_hours',
        'duration_minutes',
        'status_formatted',
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
            Crud::CREATE->value => __('New Episode Created'),
            Crud::UPDATE->value => __('Episode Updated'),
            Crud::DELETE->value => __('Episode Deleted'),
            default => null,
        };
    }
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($episode) {
            // Automatically generate a slug from the title if not provided.
            if (empty($episode->slug)) {
                $episode->slug = str()->slug($episode->title);
            }
            // Set the creator if a member is authenticated.
            if (auth()->guard('member')->check()) {
                $episode->created_by = auth()->guard('member')->user()->id;
            }
            // Set the next episode number if not provided.
            if (empty($episode->episode_number)) {
                $episode->episode_number = $episode->lastEpisodeNumber();
            }
        });
    }
    /**
     * Get the next episode number.
     *
     * @return int
     */
    protected function lastEpisodeNumber()
    {
        return self::where('program_id', $this->program_id)->max('episode_number') + 1 ?? 1;
    }
    /**
     * Get the program that owns the episode.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }
    /**
     * Get the user who created the episode.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(Member::class, 'created_by');
    }
    /**
     * Interact with the air at attribute.
     *
     * @return Attribute
     */
    public function airAtFormatted(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->air_at ?
            $this->air_at->locale(app()->getLocale())
                ->translatedFormat('l j F Y') . ' ' . timeFormat($this->air_at) : null
        );
    }
    /**
     * Interact with the air date to Arabic in input attribute.
     *
     * @return Attribute
     */
    public function airDateToArabicInInput(): Attribute
    {
        return Attribute::make(
            get: fn () => formatArabicDateTime($this->air_at)['air_date'] ?? null,
        );
    }
    /**
     * Interact with the air time to Arabic in input attribute.
     *
     * @return Attribute
     */
    public function airTimeToArabicInInput(): Attribute
    {
        return Attribute::make(
            get: fn () => formatArabicDateTime($this->air_at)['air_time'] ?? null,
        );
    }
    /**
     * Interact with the  attribute.
     *
     * @return Attribute
     */
    public function durationBetweenAirAndReminder(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->reminder_at ? $this->air_at->diffInDays($this->reminder_at) : null,
        );
    }
    /**
     * Interact with the reminder at attribute.
     *
     * @return Attribute
     */
    public function reminderAtFormatted(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->reminder_at ? $this->reminder_at
                ->locale('ar')
                ->translatedFormat('l j F Y') . ' ' . timeFormat($this->reminder_at) : null
        );
    }
    /**
     * Interact with the duration attribute as a formatted string.
     *
     * @return Attribute
     */
    public function durationToString(): Attribute
    {
        return Attribute::make(
            get: fn() => create_duration_in_hours_and_minutes($this->duration),
        );
    }
    /**
     * Interact with the duration_hours attribute.
     *
     * @return Attribute
     */
    public function durationHours(): Attribute
    {
        return Attribute::make(
            get: fn() => create_duration_in_hours_and_minutes_to_array($this->duration)['hours'],
        );
    }
    /**
     * Interact with the duration_minutes attribute.
     *
     * @return Attribute
     */
    public function durationMinutes(): Attribute
    {
        return Attribute::make(
            get: fn() => create_duration_in_hours_and_minutes_to_array($this->duration)['minutes'],
        );
    }
    /**
     * Interact with the status attribute as a formatted string.
     *
     * @return Attribute
     */
    public function statusFormatted(): Attribute
    {
        return Attribute::make(
            get: fn() => match ($this->status) {
                EpisodeStatus::DRAFT->value => $this->span('primary', __('draft')),
                EpisodeStatus::IN_PREPARATION->value => $this->span('secondary', __('in_preparation')),
                EpisodeStatus::UNDER_REVIEW->value => $this->span('info', __('under_review')),
                EpisodeStatus::APPROVED->value => $this->span('success', __('approved')),
                EpisodeStatus::SCHEDULED->value => $this->span('warning', __('scheduled')),
                EpisodeStatus::ON_AIR->value => $this->span('primary', __('on_air')),
                EpisodeStatus::COMPLETED->value => $this->span('success', __('completed')),
                EpisodeStatus::CANCELLED->value => $this->span('danger', __('cancelled')),
                EpisodeStatus::POSTPONED->value => $this->span('warning', __('postponed')),
            },
        );
    }
}
