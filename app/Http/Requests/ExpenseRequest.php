<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseRequest extends FormRequest
{
    public function authorize()
    {
        // Adjust the authorization logic as needed
        return true;
    }

    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'min:2',
                'max:50',
                'regex:/^[a-zA-Z\s]+$/',
            ],
            'description' => 'nullable|string|max:255',
            'amount' => 'required|numeric',
            'expense_date' => 'required|date',
            'category' => 'required|in:Rent,Utilities,Salaries,Maintenance,Other,Insurance,Marketing and Advertising,Cleaning,Security',
            'receipt' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
        ];
    }
}
