<?php

namespace App\Http\Requests\Workspace;

use App\Models\WorkspaceMembers;
use App\Models\WorkspaceRoles;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PresenterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'presenters' => ['required', 'array', 'min:1'],
            'presenters.*' => [
                'required',
                'integer',
                Rule::exists('members', 'id')
                   ->whereIn('workspace_role_id', WorkspaceRoles::where('slug', 'presenter')->pluck('id'))
                    ->whereIn('id', WorkspaceMembers::where('workspace_id', current_workspace()->id)->pluck('id'))
            ],
            'person_program_id' => [
                'required',
                'integer',
                Rule::exists('programs', 'id')
            ]
        ];
    }
    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'presenters.required' => __('At least one presenter is required.'),
            'presenters.array' => __('Presenters must be an array.'),
            'presenters.min' => __('At least one presenter is required.'),
            'presenters.*.required' => __('Each presenter is required.'),
            'presenters.*.integer' => __('Each presenter must be an integer.'),
            'presenters.*.exists' => __('Each presenter must exist and have the presenter role in the current workspace.'),
            'person_program_id.required' => __('The person program ID is required.'),
            'person_program_id.integer' => __('The person program ID must be an integer.'),
            'person_program_id.exists' => __('The person program ID must exist.'),
        ];
    }
}
