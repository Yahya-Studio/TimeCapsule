@extends('layouts.app')

@section('title', 'الملف الشخصي')

@section('content')
<div class="max-w-3xl mx-auto space-y-8">
    <div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-white">الملف الشخصي</h1>
        <p class="text-xs sm:text-sm text-slate-300 mt-1">إدارة معلومات حسابك وصورتك الشخصية وكلمة المرور</p>
    </div>

    <!-- Section 1: Personal Info & Avatar -->
    <div class="glass-panel rounded-3xl p-6 sm:p-10 border border-purple-500/20 bg-gradient-to-b from-[#111728]/95 to-[#0b0f19] shadow-2xl">
        <div class="flex items-center gap-4 pb-6 mb-6 border-b border-purple-500/15">
            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-16 h-16 rounded-2xl object-cover ring-4 ring-purple-500/20 shadow-lg">
            <div>
                <h2 class="text-lg font-bold text-white">{{ $user->name }}</h2>
                <p class="text-xs text-purple-300">{{ $user->email }}</p>
                <p class="text-[11px] text-slate-400 mt-0.5">عضو منذ {{ $user->created_at->format('Y/m/d') }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div>
                <label for="name" class="block text-xs font-semibold text-slate-200 mb-2">الاسم الكامل</label>
                <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required
                       class="glass-input block w-full rounded-xl px-4 py-3 text-sm">
                @error('name')
                    <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-xs font-semibold text-slate-200 mb-2">البريد الإلكتروني</label>
                <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required
                       class="glass-input block w-full rounded-xl px-4 py-3 text-sm">
                @error('email')
                    <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Timezone -->
            <div>
                <label for="timezone" class="block text-xs font-semibold text-slate-200 mb-2">المنطقة الزمنية المفضلة</label>
                <select id="timezone" name="timezone" class="glass-input block w-full rounded-xl px-4 py-3 text-sm bg-[#0b0f19]">
                    @php
                        $timezones = [
                            'Asia/Aden' => 'Asia/Aden (اليمن / صنعاء - GMT+3)',
                            'Asia/Riyadh' => 'Asia/Riyadh (السعودية / الرياض - GMT+3)',
                            'Asia/Dubai' => 'Asia/Dubai (الإمارات / دبي - GMT+4)',
                            'Africa/Cairo' => 'Africa/Cairo (مصر / القاهرة - GMT+2)',
                            'Asia/Amman' => 'Asia/Amman (الأردن / عمان - GMT+3)',
                            'Asia/Baghdad' => 'Asia/Baghdad (العراق / بغداد - GMT+3)',
                            'Africa/Casablanca' => 'Africa/Casablanca (المغرب / الدار البيضاء - GMT+1)',
                            'UTC' => 'UTC (التوقيت العالمي المنسق)',
                        ];
                    @endphp
                    @foreach ($timezones as $tzKey => $tzLabel)
                        <option value="{{ $tzKey }}" {{ old('timezone', $user->timezone) === $tzKey ? 'selected' : '' }}>
                            {{ $tzLabel }}
                        </option>
                    @endforeach
                </select>
                @error('timezone')
                    <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Avatar Upload -->
            <div>
                <label for="avatar" class="block text-xs font-semibold text-slate-200 mb-2">تحديث الصورة الشخصية (اختياري)</label>
                <input id="avatar" type="file" name="avatar" accept="image/*"
                       class="block w-full text-xs text-slate-300 file:mr-0 file:ml-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-purple-600/30 file:text-purple-200 hover:file:bg-purple-600/40 cursor-pointer">
                @error('avatar')
                    <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 flex justify-end">
                <button type="submit" 
                        class="px-6 py-3 rounded-xl text-xs font-bold text-slate-950 bg-gradient-to-r from-amber-400 to-amber-300 hover:from-amber-300 hover:to-amber-200 transition-all shadow-md">
                    حفظ التغييرات
                </button>
            </div>
        </form>
    </div>

    <!-- Section 2: Change Password -->
    <div class="glass-panel rounded-3xl p-6 sm:p-10 border border-purple-500/20 bg-gradient-to-b from-[#111728]/95 to-[#0b0f19] shadow-2xl">
        <h3 class="text-base font-bold text-white mb-2">تغيير كلمة المرور</h3>
        <p class="text-xs text-slate-300 mb-6">احرص على استخدام كلمة مرور قوية وغير مكررة لحماية كبسولاتك</p>

        <form method="POST" action="{{ route('profile.password') }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="current_password" class="block text-xs font-semibold text-slate-200 mb-2">كلمة المرور الحالية</label>
                <input id="current_password" type="password" name="current_password" required
                       placeholder="••••••••"
                       class="glass-input block w-full rounded-xl px-4 py-3 text-sm">
                @error('current_password')
                    <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="new_password" class="block text-xs font-semibold text-slate-200 mb-2">كلمة المرور الجديدة</label>
                <input id="new_password" type="password" name="password" required
                       placeholder="8 أحرف على الأقل"
                       class="glass-input block w-full rounded-xl px-4 py-3 text-sm">
                @error('password')
                    <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-xs font-semibold text-slate-200 mb-2">تأكيد كلمة المرور الجديدة</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                       placeholder="أعد كتابة كلمة المرور"
                       class="glass-input block w-full rounded-xl px-4 py-3 text-sm">
            </div>

            <div class="pt-4 flex justify-end">
                <button type="submit" 
                        class="px-6 py-3 rounded-xl text-xs font-bold text-white bg-purple-600 hover:bg-purple-500 transition-all shadow-md">
                    تحديث كلمة المرور
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
