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
            try {
                $this->merge([
                    'member_id' => decrypt($this->input('member_id')),
                ]);
            } catch (\Exception $e) {
                // If decryption fails, assume it's already a plain ID
                // This handles cases where encryption may have failed or value is null
            }
        }
        // Decrypt the membership_id before validation
        if ($this->has('membership_id')) {
            try {
                $this->merge([
                    'membership_id' => decrypt($this->input('membership_id')),
                ]);
            } catch (\Exception $e) {
                // If decryption fails, assume it's already a plain ID
            }
        }
        // Decrypt the sport_id before validation
        if ($this->has('sport_id')) {
            try {
                $this->merge([
                    'sport_id' => decrypt($this->input('sport_id')),
                ]);
            } catch (\Exception $e) {
                // If decryption fails, assume it's already a plain ID
            }
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
            'payment_date' => 'nullable|date',
            'total_amount' => 'required|numeric|min:0',
            'amount_paid' => 'required|numeric|min:0',
            'payment_method' => 'nullable|string|max:50',
            'payment_status' => 'required|in:Pending,Partial Paid,Paid',
            'auto_renew' => 'required|boolean',
            'notes' => 'nullable|string|max:255',
        ];
    }
}
