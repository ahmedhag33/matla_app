<?php

namespace App\Http\Requests\Workspace;

use App\Service\Base\JsonValidation;
use Illuminate\Foundation\Http\FormRequest;

class SegmentRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'in:' . implode(',', array_keys(segmentTypes()))],
            'duration' => ['required', 'integer', 'min:1', 'segment_duration_positive', 'segment_less_then_episode_duration', 'total_segment_duration_less_than_episode'],
            'description' => ['nullable', 'string']
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
            'title.required' => __('The title field is required.'),
            'type.required' => __('The type field is required.'),
            'duration.required' => __('The duration field is required.'),
            'duration.segment_duration_positive' => __('The segment duration must be positive.'),
            'duration.segment_less_then_episode_duration' => __('The segment duration must be less than the episode duration.'),
            'duration.total_segment_duration_less_than_episode' => __('The total duration of all segments must be less than the episode duration.'),
        ];
    }
}
