<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddReview extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required',
            'company_id' => 'required',
            'project_id' => 'required',
            'service_id' => 'required',
            'rating' => 'required',
            'message' => 'required',
        ];
    }
}