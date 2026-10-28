<?php

namespace App\Service\Database;

use App\Exceptions\DatabaseException;
use App\Models\ActivityLog;
use App\Models\Workspace;
use App\Service\Enum\Crud;
use App\Service\Enum\HttpStatusCode;
use Illuminate\Database\Eloquent\Model;

trait LogsActivity
{
    /**
     * Boot the LogsActivity trait.
     *
     * Laravel calls boot{TraitName}() automatically when the model boots.
     * This registers model event listeners that write an activity log entry
     * after each create, update, and delete.
     *
     * Note: these are Eloquent model events. Mass operations run through the
     * query builder, such as Model::where(...)->update() or ->delete(), do not
     * fire them, so they are not logged.
     *
     * @return void
     */
    protected static function bootLogsActivity(): void
    {
        // Log after a new record is inserted.
        static::created(function (Model $model) {
            $model->recordActivity(Crud::CREATE->value);
        });

        // Log after an existing record is saved with changes
        // (this only fires when at least one attribute changed).
        static::updated(function (Model $model) {
            $model->recordActivity(Crud::UPDATE->value);
        });

        // Log after a record is deleted (this includes soft deletes).
        static::deleted(function (Model $model) {
            $model->recordActivity(Crud::DELETE->value);
        });
    }
    /**
     * Write an activity log entry for this model.
     *
     * Gathers the workspace, description, and data payload from the activity
     * hooks and stores them, along with the subject model and acting member,
     * as an ActivityLog record.
     *
     * Every model using this must override getActivityDescription() to return a
     * description for each action it logs. The default returns null, which
     * makes this method throw.
     *
     * @param  string  $action  The action being logged (e.g. "create", "update", "delete").
     * @return void
     *
     * @throws DatabaseException  If no description is defined for the action and the action is not in "create", "delete", "update".
     */
    protected function recordActivity(string $action): void
    {
        if (!in_array($action, array_map(fn($status) => $status->value, Crud::cases()))) {
            throw new DatabaseException(
                'Invalid action: ' . $action,
                HttpStatusCode::INTERNAL_SERVER_ERROR->value
            );
        }
        // Workspace the activity belongs to (null if the model has none).
        $workspaceId = $this->getActivityWorkspaceId();
        // Readable description for this action, provided by the model.
        $description = $this->getActivityDescription($action);
        // Every logged action must have a description, so fail loudly if one is missing.
        if (!$description) {
            throw new DatabaseException(
                'Activity description not found for action: ' . $action,
                HttpStatusCode::INTERNAL_SERVER_ERROR->value
            );
        }
        // Create the activity log entry.
        ActivityLog::create([
            'workspace_id' => $workspaceId,
            'event' => $action,
            'action' => $action,
            'description' => $description,
            // Changed old/new values for updates, or a full attribute snapshot otherwise.
            'data' => $this->getActivityData($action),
            // Polymorphic reference to the model this activity is about.
            'subject_type' => $this->getMorphClass(),
            'subject_id' => $this->getKey(),
            // Logged-in member who did the action (null if no member is logged in, e.g. queue/CLI).
            'created_by' => auth()->guard('member')->user()->id,
        ]);
    }
    /**
     * Resolve the workspace ID to attach to activity log entries for this model.
     *
     * - If the model is itself a Workspace, its own primary key is the workspace ID.
     * - Otherwise, use the model's `workspace_id` attribute when it's set.
     * - Returns null when the model isn't tied to a workspace.
     *
     * @return int|null
     */
    protected function getActivityWorkspaceId()
    {
        // The model is a workspace, so its own ID is the workspace ID.
        if ($this instanceof Workspace) {
            return (int) $this->getKey();
        }
        // Models that belong to a workspace carry a workspace_id attribute.
        // isset() returns false for both a missing attribute and null, so either case gives null.
        return isset($this->workspace_id)
            ? (int) $this->workspace_id
            : null;
    }
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
        return null;
    }
    /**
     * Build the data payload stored with an activity log entry.
     *
     * - "update": returns only the changed attributes, as old/new pairs.
     * - Any other action (e.g. create/delete): returns a snapshot of all attributes.
     *
     * Sensitive and timestamp fields are always left out.
     *
     * Note: for "update", call this from the model's `updated`/`saved` event.
     * At that point getChanges() is filled in and getRawOriginal() still holds
     * the pre-update values.
     *
     * @param  string  $action  The action being logged.
     * @return array{old: array<string, mixed>, new: array<string, mixed>}|array{attributes: array<string, mixed>}
     */
    protected function getActivityData(string $action): array
    {
        // Attributes that should never be written to the activity log.
        $excluded = ['password', 'remember_token', 'created_at', 'updated_at'];
        // check if the action is update
        if ($action === Crud::UPDATE->value) {
            // Attributes changed by the last save, keyed by attribute name.
            $changes = $this->getChanges();
            // Drop excluded fields from the changed set.
            $newValues = array_diff_key($changes, array_flip($excluded));
            // Look up the original (pre-update) raw value of each changed attribute.
            $oldValues = [];
            // Get the original values
            foreach (array_keys($newValues) as $key) {
                $oldValues[$key] = $this->getRawOriginal($key);
            }
            // Return the old/new attribute pairs.
            return ['old' => $oldValues, 'new' => $newValues];
        }
        // For non-update actions, log the model's current attributes minus excluded fields.
        return [
            'attributes' => array_diff_key(
                $this->getAttributes(),
                array_flip($excluded)
            ),
        ];
    }
}
