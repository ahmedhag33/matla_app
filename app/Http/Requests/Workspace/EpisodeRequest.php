<?php

namespace App\Http\Requests\Workspace;

use App\Service\Base\JsonValidation;
use App\Support\EpisodeRules;
use Illuminate\Foundation\Http\FormRequest;

class EpisodeRequest extends FormRequest
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
        return EpisodeRules::step($this->route('step'));
    }
    /**
     * Get the custom validation messages.
     *
     * @return array
     */
    public function messages(): array
    {
        return EpisodeRules::messages();
    }
}
