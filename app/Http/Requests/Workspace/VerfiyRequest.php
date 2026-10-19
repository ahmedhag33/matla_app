<?php

namespace App\Http\Requests\Workspace;

use App\Service\Base\JsonValidation;
use Illuminate\Foundation\Http\FormRequest;

class VerfiyRequest extends FormRequest
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
     * @return array<string,array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'verification_code' => 'required|string',
        ];
    }
    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'verification_code.required' => __('This Field is Required'),
            'verification_code.string' => __('This Field must be String'),
        ];
    }
}
