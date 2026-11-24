<?php

namespace App\Support;

use Illuminate\Validation\Rule;

class TaskRules implements RulesInterface
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
                'episode_id' => [
                    'required',
                    'integer',
                    Rule::exists('episodes', 'id')->where('program_id', request()->input('program_id'))
                ],
                'task_context' => [
                    'required',
                    'string',
                    Rule::in(['episode', 'segment']) // Replace with actual valid contexts
                ],
                'segment_id' => [
                    Rule::requiredIf(function () {
                            return request()->input('task_context') === 'segment';
                        }),
                    'integer',
                    Rule::exists('segments', 'id')->where('episode_id', request()->input('episode_id'))
                ]
            ],
            2 => [
                'content_type' => [
                    'required',
                    'string',
                    Rule::in(['news', 'topic', 'research']) // Replace with actual valid content types
                ]
            ],
            3 => [
                'title' => [
                    'required',
                    'string',
                    'max:255'
                ],
                'description' => [
                    'required',
                    'string',
                    'max:1000'
                ],
                'requirements' => [
                    'required',
                    'array',
                ],
                'requirements.*' => [
                    'required',
                    'string',
                    Rule::in(['ready_script', 'documented_sources', 'supporting_images'])
                ]
            ],
            4 => [
                'due_date' => [
                    'required',
                    'due_date_in_future'
                ],
                'due_time' => [
                    'required',
                    'valid_due_time'
                ]
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
        return array_merge(
            self::step(1),
            self::step(2),
            self::step(3),
            self::step(4)
        );
    }
    /**
     * Get the custom validation messages.
     *
     * @return array
     */
    public static function messages(): array
    {
        return [
            'program_id.required' => __('The program ID is required'),
            'program_id.integer' => __('The program ID must be an integer'),
            'episode_id.integer' => __('The episode ID must be an integer'),
            'task_context.string' => __('The task context must be a string'),
            'segment_id.integer' => __('The segment ID must be an integer'),
            'content_type.string' => __('The content type must be a string'),
            'title.string' => __('The title must be a string'),
            'description.string' => __('The description must be a string'),
            'requirements.array' => __('The requirements must be an array'),
            'requirements.*.required' => __('Each requirement is required'),
            'requirements.*.string' => __('Each requirement must be a string'),
            'requirements.*.in' => __('Each requirement must be one of the allowed values'),
            'episode_id.required' => __('The episode ID is required'),
            'task_context.required' => __('The task context is required'),
            'segment_id.required' => __('The segment ID is required when the task context is segment'),
            'content_type.required' => __('The content type is required'),
            'title.required' => __('The title is required'),
            'description.required' => __('The description is required'),
            'requirements.required' => __('The requirements are required'),
            'due_date.required' => __('The due date is required'),
            'due_time.required' => __('The due time is required'),
            'due_date.due_date_in_future' => __('The due date must be in the future'),
            'due_time.valid_due_time' => __('The due time must be in a valid format'),
        ];
    }
}
