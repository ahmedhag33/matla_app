<?php

namespace App\Http\Requests\Client\Auth;

use App\Service\Base\JsonValidation;
use Illuminate\Foundation\Http\FormRequest;

class ForgetRequest extends FormRequest
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
     * @return array<string, |array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:users,email'
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
            'email.required' => __('Email is required'),
            'email.email' => __('Email must be a valid email address'),
            'email.exists' => __('Email does not exist in our records'),
        ];
    }
}
