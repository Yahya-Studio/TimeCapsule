@extends('layouts.guest')

@section('title', 'إنشاء حساب جديد')

@section('content')
<div class="min-h-[calc(100vh-160px)] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        <!-- Card -->
        <div class="glass-panel rounded-3xl p-8 sm:p-10 border border-purple-500/25 shadow-2xl relative overflow-hidden bg-gradient-to-b from-[#111728]/95 to-[#0b0f19]">
            <div class="text-center mb-8">
                <div class="w-14 h-14 mx-auto rounded-2xl bg-purple-600/15 border border-purple-500/30 flex items-center justify-center text-purple-300 mb-4 shadow-lg shadow-purple-900/20">
                    <i data-lucide="user-plus" class="w-7 h-7"></i>
                </div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-white">إنشاء حساب جديد</h2>
                <p class="text-xs sm:text-sm text-slate-300 mt-2">ابدأ اليوم بتخليد أفكارك ورسائلك للمستقبل</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <!-- Name Field -->
                <div>
                    <label for="name" class="block text-xs font-semibold text-slate-200 mb-2">الاسم الكامل</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                            <i data-lucide="user" class="w-4 h-4"></i>
                        </div>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                               placeholder="اسمك أو لقبك"
                               class="glass-input block w-full rounded-xl pr-10 pl-4 py-3 text-sm placeholder-slate-400">
                    </div>
                    @error('name')
                        <p class="text-xs text-rose-400 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-200 mb-2">البريد الإلكتروني</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                            <i data-lucide="mail" class="w-4 h-4"></i>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                               placeholder="your@email.com"
                               class="glass-input block w-full rounded-xl pr-10 pl-4 py-3 text-sm placeholder-slate-400">
                    </div>
                    @error('email')
                        <p class="text-xs text-rose-400 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-xs font-semibold text-slate-200 mb-2">كلمة المرور</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                            <i data-lucide="lock" class="w-4 h-4"></i>
                        </div>
                        <input id="password" type="password" name="password" required
                               placeholder="8 أحرف على الأقل"
                               class="glass-input block w-full rounded-xl pr-10 pl-4 py-3 text-sm placeholder-slate-400">
                    </div>
                    @error('password')
                        <p class="text-xs text-rose-400 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Confirmation Field -->
                <div>
                    <label for="password_confirmation" class="block text-xs font-semibold text-slate-200 mb-2">تأكيد كلمة المرور</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                            <i data-lucide="check" class="w-4 h-4"></i>
                        </div>
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                               placeholder="أعد كتابة كلمة المرور"
                               class="glass-input block w-full rounded-xl pr-10 pl-4 py-3 text-sm placeholder-slate-400">
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-3">
                    <button type="submit" 
                            class="w-full inline-flex items-center justify-center gap-2 py-3.5 px-4 rounded-xl text-sm font-bold text-slate-950 bg-gradient-to-r from-amber-400 to-amber-300 hover:from-amber-300 hover:to-amber-200 shadow-xl shadow-amber-500/20 hover:scale-[1.01] transition-all">
                        <i data-lucide="sparkles" class="w-4 h-4 stroke-[2.5]"></i>
                        <span>إنشاء الحساب وبدء التجربة</span>
                    </button>
                </div>
            </form>

            <div class="mt-8 text-center text-xs text-slate-400 pt-6 border-t border-purple-500/15">
                لديك حساب بالفعل؟
                <a href="{{ route('login') }}" class="text-amber-400 font-semibold hover:text-amber-300 transition-colors mr-1">
                    تسجيل الدخول
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
