<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SettingsRequest extends FormRequest
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
    public function rules()
    {
        return [
            'domain' => 'required|string|max:255',
            'sender_mail' => 'required|string|email|max:255',
            'sender_name' => 'nullable|string|max:255',
            'email_host' => 'nullable|string|max:255',
            'email_username' => 'nullable|string|max:255',
            'email_password' => 'nullable|string|max:255',
            'email_port' => 'nullable|string|max:10',
            'email_smtp_auth' => 'required|boolean',
            'email_smtp_secure' => 'nullable|string|max:255',
            'iptv_host_url' => 'nullable|string|max:255',
            'iptv_portal_link' => 'nullable|string|max:255',
        ];
    }
}
