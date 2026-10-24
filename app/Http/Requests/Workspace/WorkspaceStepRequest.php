<?php

namespace App\Http\Requests\Workspace;

use App\Service\Base\JsonValidation;
use App\Support\WorkspaceRules;
use Illuminate\Foundation\Http\FormRequest;

class WorkspaceStepRequest extends FormRequest
{
    use JsonValidation;
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
        return WorkspaceRules::step($this->route('step'));
    }
    /**
     * Get the custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return WorkspaceRules::messages();
    }
}
