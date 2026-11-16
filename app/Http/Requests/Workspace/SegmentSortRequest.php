<?php

namespace App\Http\Requests\Workspace;

use App\Service\Base\JsonValidation;
use Illuminate\Foundation\Http\FormRequest;

class SegmentSortRequest extends FormRequest
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
            'segments_id' => ['required', 'integer'],
            'segment_number' => ['required', 'integer'],
        ];
    }
    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'segments_id.required' => 'Segment ID is required.',
            'segments_id.integer' => 'Segment ID must be an integer.',
            'segment_number.required' => 'Segment number is required.',
            'segment_number.integer' => 'Segment number must be an integer.',
        ];
    }
    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'segments_id' => 'Segment ID',
            'segment_number' => 'Segment number',
        ];
    }
}
