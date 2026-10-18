<?php

namespace App\Http\Requests\Workspace;

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
            'email' => 'required|string|email|unique:members,email',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|not_in:0|exists:workspace_roles,id',
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
            'password.confirmed' => __('Your password does not match'),
            'role_id.required' => __('This Field is Required'),
            'role_id.not_in' => __('Please Select a Role'),
            'role_id.exists' => __('This Role does not exist'),
        ];
    }
}
