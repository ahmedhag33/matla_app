<?php

namespace App\Support;

use App\Models\WorkspaceRoles;
use App\Service\Enum\BroadcastSchedule;
use App\Service\Enum\BroadcastMode;
use App\Service\Enum\ProgramStatus;
use Illuminate\Validation\Rule;

class ProgramRules implements RulesInterface
{
    /**
     * Get the validation rules for a specific step.
     *
     * @param int $step
     * @return array
     */
    public static function step(int $step): array
    {
        return match ($step) {
            1 => [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('programs', 'name')
                        ->where('program_id', request()->input('program_id'))
                ],
                'slug' => [
                    'required',
                    'string',
                    'max:255',
                    'regex:/^[a-z0-9-]+$/',
                    Rule::unique('programs', 'slug')
                        ->where('program_id', request()->input('program_id'))
                ],
                'program_type_id' => [
                    'required',
                    'integer',
                    Rule::exists('program_types', 'id')
                ]
            ],
            2 => [
                'presenters.*' => [
                    'required',
                    'integer',
                    Rule::exists('members', 'id')->whereIn('role_id', WorkspaceRoles::where('name', 'presenter')->pluck('id')),
                ],
            ],
            3 => [
                'broadcast_schedule' => ['required', 'string', Rule::enum(BroadcastSchedule::class)],
                'duration_hours' => ['required', 'integer'],
                'duration_minutes' => ['required', 'integer','min:0','max:60'],
                'broadcast_mode' => ['required', 'string', Rule::enum(BroadcastMode::class)],
                'days_of_the_week.*' => ['required', 'string', Rule::in(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'])]
            ],
            4 => [
                'status' => ['required', 'string', Rule::enum(ProgramStatus::class)],
            ],
            default => [],
        };
    }
    /**
     * Get all the validation rules.
     *
     * @return array
     */
    public static function all(): array
    {
        return array_merge(self::step(1), self::step(2), self::step(3), self::step(4));
    }
    /**
     * Get the custom validation messages.
     *
     * @return array
     */
    public static function messages(): array
    {
        return [
            'name.required' => __('The program name is required.'),
            'name.string' => __('The program name must be a string.'),
            'name.max' => __('The program name must not exceed 255 characters.'),
            'slug.required' => __('The program slug is required.'),
            'slug.string' => __('The program slug must be a string.'),
            'slug.max' => __('The program slug must not exceed 255 characters.'),
            'slug.regex' => __('The program slug format is invalid.'),
            'slug.unique' => __('The program slug has already been taken.'),
            'program_type_id.required' => __('The program type is required.'),
            'program_type_id.integer' => __('The program type must be an integer.'),
            'program_type_id.exists' => __('The selected program type is invalid.'),
            'presenters.*.required' => __('The presenter is required.'),
            'presenters.*.integer' => __('The presenter must be an integer.'),
            'presenters.*.exists' => __('The selected presenter is invalid.'),
            'broadcast_schedule.required' => __('The broadcast schedule is required.'),
            'broadcast_schedule.string' => __('The broadcast schedule must be a string.'),
            'broadcast_schedule.enum' => __('The selected broadcast schedule is invalid.'),
            'duration_hours.required' => __('The duration hours is required.'),
            'duration_hours.integer' => __('The duration hours must be an integer.'),
            'duration_minutes.required' => __('The duration minutes is required.'),
            'duration_minutes.integer' => __('The duration minutes must be an integer.'),
            'duration_hours.min' => __('The duration hours must be at least 0.'),
            'duration_minutes.min' => __('The duration minutes must be at least 0.'),
            'duration_hours.max' => __('The duration hours must not exceed 23.'),
            'duration_minutes.max' => __('The duration minutes must not exceed 60.'),
            'broadcast_mode.required' => __('The broadcast mode is required.'),
            'broadcast_mode.string' => __('The broadcast mode must be a string.'),
            'broadcast_mode.enum' => __('The selected broadcast mode is invalid.'),
            'day_of_the_week.required' => __('The day of the week is required.'),
            'day_of_the_week.string' => __('The day of the week must be a string.'),
            'day_of_the_week.in' => __('The selected day of the week is invalid.'),
            'status.required' => __('The program status is required.'),
            'status.string' => __('The program status must be a string.'),
            'status.enum' => __('The selected program status is invalid.')
        ];
    }
}
