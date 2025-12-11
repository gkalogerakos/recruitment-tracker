<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'recruiter_id' => [
                'required',
                'integer',
                'exists:recruiters,id' // Check if the recruiter_id exists
            ],
            'candidate_name' => 'required|string|max:255',
            'candidate_surname' => 'required|string|max:255',
        ];
    }
}
