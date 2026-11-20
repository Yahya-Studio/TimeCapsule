<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return !auth()->check();
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'يرجى إدخال اسم المستخدم.',
            'name.max' => 'اسم المستخدم طويل جداً.',
            'email.required' => 'يرجى إدخال البريد الإلكتروني.',
            'email.email' => 'البريد الإلكتروني المدخل غير صالح.',
            'email.unique' => 'هذا البريد الإلكتروني مسجل مسبقاً لدينا.',
            'password.required' => 'يرجى إدخال كلمة المرور.',
            'password.min' => 'يجب ألا تقل كلمة المرور عن 8 أحرف.',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق.',
        ];
    }
}
