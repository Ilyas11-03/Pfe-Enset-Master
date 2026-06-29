<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PlanRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'min:2',
                'max:50',
            ],
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'discount_percentage' => 'nullable|int|min:0|max:100',
            'user_limit' => 'required|integer|min:1',
            'member_limit' => 'required|integer|min:1',
        ];
    }
}
