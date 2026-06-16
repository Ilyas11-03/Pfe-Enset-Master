<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GymPlanRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'gym_id' => 'required|exists:gyms,id',
            'plan_id' => 'required|exists:plans,id',
            'start_date' => 'required|date',
            'duration' => 'required|integer|in:1,3,6,12,24', // Use in: for duration select options
            'total_amount' => 'nullable|numeric|min:0', // Changed to integer
            'amount_paid' => 'required|numeric|min:0', // Changed to integer
            'discount_amount' => 'nullable|numeric|min:0', // Changed to integer
            'payment_status' => 'required|in:Pending,Partial Paid,Paid',
            'payment_method' => 'nullable|in:Cash,Credit Card,Bank Transfer', // Use in: for select options
            'due_date' => 'nullable|date',
            'auto_renew' => 'required|boolean',
            'notes' => 'nullable|string|max:255',

        ];
    }
}
