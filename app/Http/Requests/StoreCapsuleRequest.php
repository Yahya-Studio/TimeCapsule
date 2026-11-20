<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StoreCapsuleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Prepare inputs before validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->filled('open_date') && $this->filled('open_time')) {
            $userTimezone = auth()->user()->timezone ?? 'Asia/Aden';
            try {
                $combined = Carbon::createFromFormat(
                    'Y-m-d H:i',
                    $this->input('open_date') . ' ' . $this->input('open_time'),
                    $userTimezone
                );

                $this->merge([
                    'open_datetime' => $combined ? $combined->toIso8601String() : null,
                ]);
            } catch (\Exception $e) {
                // Let validator catch format errors
            }
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'message' => ['required', 'string', 'min:5'],
            'open_date' => ['required', 'date_format:Y-m-d'],
            'open_time' => ['required', 'date_format:H:i'],
            'open_datetime' => ['required', 'after:now'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,gif', 'max:5120'],
        ];
    }

    /**
     * Get custom error messages in Arabic.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'يرجى كتابة عنوان الكبسولة الزمنية.',
            'title.max' => 'عنوان الكبسولة لا يمكن أن يتجاوز 255 حرفاً.',
            'description.max' => 'الوصف لا يمكن أن يتجاوز 1000 حرف.',
            'message.required' => 'محتوى الرسالة مطلوب، اكتب ما تريد حفظه للمستقبل.',
            'message.min' => 'يجب أن تحتوي الرسالة على 5 أحرف على الأقل.',
            'open_date.required' => 'يرجى تحديد تاريخ فتح الكبسولة.',
            'open_date.date_format' => 'صيغة تاريخ الفتح غير صحيحة.',
            'open_time.required' => 'يرجى تحديد وقت فتح الكبسولة.',
            'open_time.date_format' => 'صيغة وقت الفتح غير صحيحة.',
            'open_datetime.after' => 'يجب أن يكون موعد فتح الكبسولة في المستقبل، لا يمكن اختيار موعد سابق أو حالي.',
            'open_datetime.required' => 'موعد الفتح المحدد غير صالح.',
            'image.image' => 'الملف المرفق يجب أن يكون صورة صالحة.',
            'image.mimes' => 'أنواع الصور المسموح بها هي: jpeg, png, jpg, webp, gif.',
            'image.max' => 'أقصى حجم للصورة المرفقة هو 5 ميجابايت.',
        ];
    }
}
