<?php

namespace App\Http\Requests;

use App\Rules\UniqueStepCategoryPerTimeline;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StoreStepRequest extends FormRequest
{
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'recruiter_id' => [
                'required',
                'integer',
                'exists:recruiters,id', // Check if the recruiter_id exists
            ],
            'candidate_id' => [
                'required',
                'integer',
                'exists:candidates,id', // Check if the candidate_id exists
            ],
            'timeline_id' => [
                'required',
                'integer',
                'exists:timelines,id', // Check if the timeline_id exists
                Rule::exists('timelines', 'id')->where('candidate_id', $this->candidate_id),
            ],
            'step_category_id' => [
                'required',
                'integer',
                'exists:step_categories,id', // Check if the step_category_id exists
                new UniqueStepCategoryPerTimeline($this->timeline_id),
            ],
            'status_category_id' => [
                'required',
                'integer',
                'exists:status_categories,id', // Check if the status_category_id exists
            ],
        ];
    }

    /**
     * Custom error messages for validation failures.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'recruiter_id.required' => 'Recruiter id is required.',
            'recruiter_id.integer' => 'Recruiter id must be an integer.',
            'recruiter_id.exists' => 'Selected recruiter does not exist.',

            'candidate_id.required' => 'Candidate id is required.',
            'candidate_id.integer' => 'Candidate id must be an integer.',
            'candidate_id.exists' => 'Selected candidate does not exist.',

            'timeline_id.required' => 'Timeline id is required.',
            'timeline_id.integer' => 'Timeline id must be an integer.',
            'timeline_id.exists' => 'The selected timeline does not belong to the given candidate or does not exist.',

            'step_category_id.required' => 'Step category is required.',
            'step_category_id.integer' => 'Step category id must be an integer.',
            'step_category_id.exists' => 'Selected step category does not exist.',

            'status_category_id.required' => 'Status category is required.',
            'status_category_id.integer' => 'Status category id must be an integer.',
            'status_category_id.exists' => 'Selected status category does not exist.',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     *
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator): void
    {
        // Throw a custom HTTP response exception
        throw new HttpResponseException(response()->json([
            // 1. Your Custom Top-Level Message
            'message' => 'Validation failed for the step creation request.',

            // 2. The detailed errors from the validator
            'errors' => $validator->errors(),
        ], 422)); // Use HTTP 422 Unprocessable Entity
    }
}
