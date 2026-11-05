<?php

namespace App\Models;

use App\Service\Database\LogsActivity;
use App\Service\Enum\Crud;
use Illuminate\Database\Eloquent\Model;

class ProgramTeam extends Model
{
    use LogsActivity;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'program_team';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'program_id',
        'team_member_id',
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
            Crud::CREATE->value => __('New Program Team Member Created'),
            Crud::UPDATE->value => __('Program Team Member Updated'),
            Crud::DELETE->value => __('Program Team Member Deleted'),
            default => null,
        };
    }
}
