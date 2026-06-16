<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordChangeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'currentPassword' => 'required',
            'newPassword' => 'required|min:8|confirmed',
        ];
    }
}
