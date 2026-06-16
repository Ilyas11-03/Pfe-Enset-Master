<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        // Decrypt the member_id before validation
        if ($this->has('member_id')) {
            $this->merge([
                'member_id' => decrypt($this->input('member_id')),
            ]);
        }
        // Decrypt the membership_id before validation
        if ($this->has('membership_id')) {
            $this->merge([
                'membership_id' => decrypt($this->input('membership_id')),
            ]);
        }
        // Decrypt the sport_id before validation
        if ($this->has('sport_id')) {
            $this->merge([
                'sport_id' => decrypt($this->input('sport_id')),
            ]);
        }
    }

    public function rules()
    {
        return [
            'member_id' => 'required|exists:members,id',
            'membership_id' => 'required|exists:memberships,id',
            'sport_id' => 'required|exists:sports,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'total_amount' => 'required|numeric|min:0',
            'amount_paid' => 'required|numeric|min:0',
            'payment_status' => 'required|in:Pending,Partial Paid,Paid',
            'auto_renew' => 'required|boolean',
            'notes' => 'nullable|string|max:255',
        ];
    }
}
