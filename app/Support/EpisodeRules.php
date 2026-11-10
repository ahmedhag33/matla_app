<?php

namespace App\Support;

use Illuminate\Validation\Rule;

class EpisodeRules implements RulesInterface
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
                'program_id' => [
                    'required',
                    'integer',
                    Rule::exists('programs', 'id')->where('workspace_id', current_workspace()->id)
                ],
                'title' => ['required', 'string', 'max:255'],
                'description' => ['required', 'string', 'max:1000'],
            ],
            2 => [
                'air_date' => ['required', 'date', 'episode_scheduled_on_program_day'],
                'air_time' => ['required', 'date_format:H:i'],
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
        return array_merge(self::step(1), self::step(2));
    }
    /**
     * Get the custom validation messages.
     *
     * @return array
     */
    public static function messages(): array
    {
        return [
            'program_id.required' => __('The program ID field is required.'),
            'program_id.integer' => __('The program ID must be an integer.'),
            'program_id.exists' => __('The selected program is invalid.'),
            'title.required' => __('The title field is required.'),
            'title.string' => __('The title must be a string.'),
            'title.max' => __('The title may not be greater than 255 characters.'),
            'description.required' => __('The description field is required.'),
            'description.string' => __('The description must be a string.'),
            'description.max' => __('The description may not be greater than 1000 characters.'),
            'air_date.required' => __('The air date field is required.'),
            'air_date.date' => __('The air date must be a valid date.'),
            'air_date.episode_scheduled_on_program_day' => __('The air date must match one of the programs broadcast days.'),
            'air_time.required' => __('The air time field is required.'),
            'air_time.date_format' => __('The air time must be in the format H:i.'),
        ];
    }
}
