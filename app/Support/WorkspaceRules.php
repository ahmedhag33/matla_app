<?php

namespace App\Support;

class WorkspaceRules
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
                'name' => ['required', 'string', 'max:255', 'unique:workspaces,name'],
                'description' => ['nullable', 'string', 'max:1000'],
            ],
            2 => [
                'country_id' => ['required', 'integer', 'exists:countries,id']
            ],
            3 => [
                'workspace_type_id' => ['required', 'integer', 'exists:workspace_types,id']
            ],
            default => abort(404),
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
            'name.required' => __('Please Enter Workspace Name'),
            'name.string' => __('This Field must be String'),
            'name.max' => __('This Field must not exceed 255 characters'),
            'name.unique' => __('Workspace is already taken'),
            'country_id.required' => __('Please select a country'),
            'workspace_type_id.required' => __('Please choose your media activity'),
        ];
    }
}
