<?php

namespace App\Models;

use App\Service\Database\LogsActivity;
use App\Service\Enum\Crud;
use Illuminate\Database\Eloquent\Model;

class ProgramPresenters extends Model
{
    use LogsActivity;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'program_presenters';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'program_id',
        'presenter_id',
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
            Crud::CREATE->value => __('New Program Presenter Created'),
            Crud::UPDATE->value => __('Program Presenter Updated'),
            Crud::DELETE->value => __('Program Presenter Deleted'),
            default => null,
        };
    }
}
