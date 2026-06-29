<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:2',
                'max:50',
                'regex:/^[a-zA-Z\s]+$/',
            ],
            'email' => 'required|string|email|max:255|unique:users,email,'.$this->user()->id,
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|max:1024',
        ];
    }
}
