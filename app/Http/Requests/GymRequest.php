<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class GymRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Authorize all requests for now. Adjust as needed.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $id = $this->route('gym'); // Adjust route parameter name if necessary

        return [
            'name' => [
                'required',
                'string',
                'min:2',
                'max:50',
                'regex:/^[a-zA-Z\s]+$/'
            ],
            'address' => 'required|string|max:255',
            'domain' => 'required|string|max:255',
            'city' => 'nullable|string|max:255',
            'region' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'operating_hours' => 'nullable|string|max:255',
            // 'plan_id' => 'required|exists:plans,id',
            // 'starts_at' => 'required|date',
            // 'expires_at' => 'nullable|date', 
            // 'duration' => 'required|numeric|min:1',
            'status' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:800',
        ];
    }
}
