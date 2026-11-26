<?php

namespace App\Models;

use App\Models\Episode;
use App\Models\Member;
use App\Models\Scopes\CurrentWorkspaceScope;
use App\Models\Segments;
use App\Service\Database\LogsActivity;
use App\Service\Enum\Crud;
use App\Service\Enum\TaskEnum;
use App\Service\Enum\TaskPriorityEnum;
use App\Service\Layouts\GenralStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    use LogsActivity, GenralStatus;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tasks';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug',
        'workspace_id',
        'episode_id',
        'task_context',
        'segment_id',
        'content_type',
        'content_id',
        'title',
        'description',
        'requirements',
        'source',
        'assigned_id',
        'status',
        'priority',
        'due_at',
        'completed_at',
        'created_by'
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'requirements' => 'array',
        'due_at' => 'datetime',
        'completed_at' => 'datetime',
        'created_by' => 'integer',
    ];
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'due_at_formatted',
        'completed_at_formatted',
        'status_formatted',
        'priority_formatted',
        'content_string',
        'requirements_to_string'
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
            Crud::CREATE->value => __('New Task Created'),
            Crud::UPDATE->value => __('Task Updated'),
            Crud::DELETE->value => __('Task Deleted'),
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

        static::creating(function ($task) {
            $task->slug = str()->uuid();
            // Set the created_by attribute to the currently authenticated member's ID if available.
            if (auth()->guard('member')->check()) {
                $task->created_by = auth()->guard('member')->user()->id;
            }
            $task->status = TaskEnum::PENDING->value;
            // Set the workspace ID to the current workspace.
            $task->workspace_id = current_workspace()->id;
            // Set the content ID to 0 initially.
            $task->content_id = 0;
        });
        // Apply the current workspace scope globally.
        static::addGlobalScope(new CurrentWorkspaceScope());
    }
    /**
     * The member who created the task.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(Member::class, 'created_by');
    }
    /**
     * The member to whom the task is assigned.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assignee()
    {
        return $this->belongsTo(Member::class, 'assigned_id');
    }
    /**
     * The episode associated with the task.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function episode()
    {
        return $this->belongsTo(Episode::class, 'episode_id');
    }
    /**
     * The segment associated with the task.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function segment()
    {
        return $this->belongsTo(Segments::class, 'segment_id');
    }
    /**
     * Interact with the due at attribute.
     *
     * @return Attribute
     */
    public function dueAtFormatted(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->due_at ? $this->due_at
                ->locale('ar')
                ->translatedFormat('l j F Y') . ' ' . timeFormat($this->due_at) : null
        );
    }
    /**
     * Interact with the completed at attribute.
     *
     * @return Attribute
     */
    public function completedAtFormatted(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->completed_at ? $this->completed_at
                ->locale('ar')
                ->translatedFormat('l j F Y') . ' ' . timeFormat($this->completed_at) : null
        );
    }
    /**
     * Interact with the status attribute.
     *
     * @return Attribute
     */
    public function statusFormatted(): Attribute
    {
        return Attribute::make(
            get: fn() => match ($this->status) {
                TaskEnum::PENDING->value => $this->span('warning', __('Pending')),
                TaskEnum::IN_PROGRESS->value => $this->span('primary', __('In Progress')),
                TaskEnum::COMPLETED->value => $this->span('success', __('Completed')),
            },
        );
    }
    /**
     * Interact with the priority attribute.
     *
     * @return Attribute
     */
    public function priorityFormatted(): Attribute
    {
        return Attribute::make(
            get: fn() => match ($this->priority) {
                TaskPriorityEnum::LOW->value => $this->span('warning', __('Low')),
                TaskPriorityEnum::MEDIUM->value => $this->span('primary', __('Medium')),
                TaskPriorityEnum::HIGH->value => $this->span('success', __('High')),
            },
        );
    }
    /**
     * Interact with the contentString attribute.
     *
     * @return Attribute
     */
    public function contentString(): Attribute
    {
        return Attribute::make(
            get: fn() => match ($this->content_type) {
                'news' => __('New'),
                'topics' => __('Topic'),
                'researchs' => __('Research'),
                default => __('Unknown'),
            },
        );
    }
    /**
     * Interact with the requirementsToString attribute.
     *
     * @return Attribute
     */
    public function requirementsToString(): Attribute
    {
        return Attribute::make(
            get: function () {
                $requirements = json_decode(
                    $this->getRawOriginal('requirements') ?? '[]',
                    true
                );
                return implode(' - ', array_map(
                    fn($requirement) => requirementTypes()[$requirement] ?? $requirement,
                    $requirements
                ));
            }
        );
    }
}
