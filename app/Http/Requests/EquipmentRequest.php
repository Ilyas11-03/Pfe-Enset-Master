<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EquipmentRequest extends FormRequest
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
            ],
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:800',
            'quantity' => 'required|integer',
            'amount' => 'required|numeric',
            'purchase_date' => 'required|date',
            'condition' => 'required|string|in:New,Good,Poor',
            'maintenance_date' => 'nullable|date',
            'serial_number' => 'nullable|string|max:255',
        ];
    }
}
