<?php

namespace App\Http\Requests\Workspace;

use App\Service\Base\JsonValidation;
use Illuminate\Foundation\Http\FormRequest;

class InventionRequest extends FormRequest
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
        return [
            'email' => 'required|email',
            'name' => 'required|string|max:255',
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
            'role_id.required' => __('This Field is Required'),
            'role_id.not_in' => __('Please Select a Role'),
            'role_id.exists' => __('This Role does not exist'),
        ];
    }
}
