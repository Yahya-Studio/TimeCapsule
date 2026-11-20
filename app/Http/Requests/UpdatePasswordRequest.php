<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'current_password.required' => 'يرجى إدخال كلمة المرور الحالية.',
            'current_password.current_password' => 'كلمة المرور الحالية غير صحيحة.',
            'password.required' => 'يرجى إدخال كلمة المرور الجديدة.',
            'password.min' => 'يجب ألا تقل كلمة المرور الجديدة عن 8 أحرف.',
            'password.confirmed' => 'تأكيد كلمة المرور الجديدة غير متطابق.',
        ];
    }
}
