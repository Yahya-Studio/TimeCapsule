<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return !auth()->check();
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
            'remember' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'يرجى إدخال البريد الإلكتروني.',
            'email.email' => 'البريد الإلكتروني غير صالح.',
            'password.required' => 'يرجى إدخال كلمة المرور.',
        ];
    }
}
