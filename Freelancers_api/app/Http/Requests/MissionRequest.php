<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class MissionRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => "required|exists:categories,id",
            'titre'       => "required|string",
            'description' => "required|string",
            'budget'      => "required|numeric|min:0",
            'duration'    => "required|integer|min:1",
            'status'      => 'nullable|string',
            'technologies' => 'nullable|array',
        ];
    }
}
