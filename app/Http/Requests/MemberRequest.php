<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class MemberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        // You may add any additional authorization logic here
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        $user = Auth::user();

        // Check if the route has a member ID and attempt decryption if it does
        $id = null;
        if ($this->route('member')) {
            $id = decrypt($this->route('member'));
        }

        // Common rules
        $rules = [
            'name' => [
                'required',
                'string',
                'min:2',
                'max:50',
                'regex:/^[a-zA-Z\s]+$/'
            ],
            'email' => 'required|string|email|max:255|unique:members,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'gender' => 'nullable|in:male,female,other',
            'join_date' => 'required|date',
            'status' => 'nullable',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:800',
        ];

        // Rules for gym admins
        // if ($user->role === 'gym_admin') {
        //     $rules['gym_id'] = 'required|exists:gyms,id';
        // }

        // Additional rules for staff (if any)
        if ($user->role === 'staff') {
            // Staff-specific rules can be added here
        }

        return $rules;
    }
}
