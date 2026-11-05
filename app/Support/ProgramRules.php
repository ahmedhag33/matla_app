<?php

namespace App\Support;

use App\Models\WorkspaceMembers;
use App\Service\Enum\BroadcastMode;
use App\Service\Enum\BroadcastSchedule;
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
                        ->where('id', request()->input('program_id'))
                ],
                'slug' => [
                    'required',
                    'string',
                    'max:255',
                    'regex:/^[a-z0-9-]+$/',
                    Rule::unique('programs', 'slug')
                        ->where('id', request()->input('program_id'))
                ],
                'program_type_id' => [
                    'required',
                    'integer',
                    Rule::exists('program_types', 'id')
                ]
            ],
            2 => [
                'team_members' => ['required', 'array', 'min:1'],
                'team_members.*' => [
                    'required',
                    'integer',
                    Rule::exists('members', 'id')
                        ->whereIn('id', WorkspaceMembers::where('workspace_id', current_workspace()->id)->pluck('member_id'))
                ],
            ],
            3 => [
                'broadcast_schedule' => ['required', 'string', Rule::enum(BroadcastSchedule::class)],
                'duration_hours' => ['required', 'integer'],
                'duration_minutes' => ['required', 'integer', 'min:0', 'max:60'],
                'broadcast_mode' => ['required', 'string', Rule::enum(BroadcastMode::class)],
                'days_of_the_week' => ['required', 'array', 'min:1'],
                'days_of_the_week.*' => ['required', 'string', Rule::in(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'])]
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
        return array_merge(self::step(1), self::step(2), self::step(3));
    }
    /**
     * Get the custom validation messages.
     *
     * @return array
     */
    public static function messages(): array
    {
        return [
            // step 1 rules
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
            // step 3 rules
            'team_members.required' => __('The team is required.'),
            'team_members.array' => __('The team must be an array.'),
            'team_members.min' => __('The team must have at least one member.'),
            'team_members.*.required' => __('Each team member is required.'),
            'team_members.*.integer' => __('Each team member must be an integer.'),
            'team_members.*.exists' => __('The selected team member is invalid.'),
            // step 2 rules
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
            'days_of_the_week.required' => __('The days of the week is required.'),
            'days_of_the_week.array' => __('The days of the week must be an array.'),
            'days_of_the_week.min' => __('The days of the week must have at least one day.')
        ];
    }
}
