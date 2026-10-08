<?php

namespace App\Http\Requests\Client\Auth;

use App\Service\Base\JsonValidation;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed'
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
            'name.required' => __('This Field is Required'),
            'name.string' => __('String Only'),
            'email.required' => __('This Field is Required'),
            'email.email' => __('Your Email must consist of @'),
            'email.unique' => __('This Email Alreadly Exit'),
            'password.required' => __('This Field is Required'),
            'password.min' => __('Your password must be consist of at least 8 characters'),
        ];
    }
}
