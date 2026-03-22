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
            'title'       => "required|string|max:200",
            'description' => "required|string",
            'budget'      => "required|numeric|min:0",
            'duration'    => "required|string|max:100",
            'status'      => 'nullable|string',

        ];
    }
}
