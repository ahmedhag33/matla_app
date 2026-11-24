<?php

namespace App\Http\Requests\Workspace;

use App\Service\Base\JsonValidation;
use App\Support\TaskRules;
use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
        return TaskRules::step((int) $this->route('taskStep'));
    }
    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return TaskRules::messages();
    }
}
