<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreTimelineRequest extends FormRequest
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
            'candidate_name' => 'required|string',
            'candidate_surname' => 'required|string',
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

            'candidate_name.required' => "Candidate's name is required.",
            'candidate_name.string' => "Candidate's name must be a string.",

            'candidate_surname.required' => "Candidate's surname is required.",
            'candidate_surname.string' => "Candidate's surname must be a string.",
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

        throw new HttpResponseException(response()->json([
            'message' => 'Validation failed for the timeline creation request.',
            'errors' => $validator->errors(),
        ], 422)); // Use HTTP 422 Unprocessable Entity
    }
}
