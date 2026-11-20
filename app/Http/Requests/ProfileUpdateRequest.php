<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore(auth()->id())],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'timezone' => ['required', 'string', 'timezone'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'اسم المستخدم مطلوب.',
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email' => 'صيغة البريد الإلكتروني غير صالحة.',
            'email.unique' => 'البريد الإلكتروني مستخدم من قِبل حساب آخر.',
            'avatar.image' => 'يجب أن يكون الملف المرفوع صورة.',
            'avatar.mimes' => 'صيغ الصور المسموح بها: jpeg, png, jpg, webp.',
            'avatar.max' => 'أقصى حجم للصورة هو 2 ميجابايت.',
            'timezone.required' => 'المنطقة الزمنية مطلوبة.',
            'timezone.timezone' => 'المنطقة الزمنية المحددة غير صحيحة.',
        ];
    }
}
