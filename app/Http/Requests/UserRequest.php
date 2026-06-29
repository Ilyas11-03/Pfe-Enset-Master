<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        // Determine if we are dealing with an encrypted ID or plain ID
        $isEncryptedId = $this->route('staff') || $this->route('user');

        // If encrypted ID, decrypt it
        $id = null;
        if ($isEncryptedId) {
            $id = $this->route('staff') ? decrypt($this->route('staff')) : decrypt($this->route('user'));
        } else {
            $id = $this->route('id');
        }

        $rules = [
            'gym_id' => [
                'nullable',
                'exists:gyms,id',
            ],
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($id),
            ],
            'password' => 'nullable|string|min:8|max:255|regex:/^(?=.*[a-z])(?=.*[\d\s\W]).+$/',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:800',
            'role' => 'required|in:gym_admin,staff,coach',
            'status' => 'nullable',
            // 'created_by' => 'required|exists:users,id',  // Add this line
            // 'updated_by' => 'sometimes|exists:users,id', // Add this line
        ];

        // Add required rule for password only in the create form
        if ($this->isMethod('POST')) {
            $rules['password'] = 'required|string|min:8|max:255|regex:/^(?=.*[a-z])(?=.*[\d\s\W]).+$/';
        }

        // Custom validation to ensure only one gym_admin per gym
        if ($this->input('role') === 'gym_admin') {
            $rules['gym_id'][] = function ($attribute, $value, $fail) {
                $existingAdmin = User::where('gym_id', $value)
                    ->where('role', 'gym_admin')
                    ->where('id', '!=', $this->route('id')) // Exclude the current user
                    ->first();

                if ($existingAdmin) {
                    $fail('A Gym Admin already exists for this gym.');
                }
            };
        }

        return $rules;
    }
}
