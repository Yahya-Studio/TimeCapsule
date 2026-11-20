@extends('layouts.guest')

@section('title', 'تسجيل الدخول')

@section('content')
<div class="min-h-[calc(100vh-160px)] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        <!-- Card -->
        <div class="glass-panel rounded-3xl p-8 sm:p-10 border border-purple-500/25 shadow-2xl relative overflow-hidden bg-gradient-to-b from-[#111728]/95 to-[#0b0f19]">
            <div class="text-center mb-8">
                <div class="w-14 h-14 mx-auto rounded-2xl bg-amber-400/10 border border-amber-400/25 flex items-center justify-center text-amber-400 mb-4 shadow-lg shadow-amber-500/10">
                    <i data-lucide="key-round" class="w-7 h-7"></i>
                </div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-white">تسجيل الدخول</h2>
                <p class="text-xs sm:text-sm text-slate-300 mt-2">عد إلى كبسولاتك الزمنية واكتشف ما ينتظرك</p>
            </div>

            @if (session('status'))
                <div class="p-3 mb-6 rounded-xl bg-purple-900/30 border border-purple-500/30 text-purple-200 text-xs text-center">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-200 mb-2">البريد الإلكتروني</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                            <i data-lucide="mail" class="w-4 h-4"></i>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                               placeholder="your@email.com"
                               class="glass-input block w-full rounded-xl pr-10 pl-4 py-3 text-sm placeholder-slate-400">
                    </div>
                    @error('email')
                        <p class="text-xs text-rose-400 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="password" class="block text-xs font-semibold text-slate-200">كلمة المرور</label>
                        <a href="{{ route('password.request') }}" class="text-xs text-amber-400 hover:text-amber-300 transition-colors">
                            نسيت كلمة المرور؟
                        </a>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                            <i data-lucide="lock" class="w-4 h-4"></i>
                        </div>
                        <input id="password" type="password" name="password" required
                               placeholder="••••••••"
                               class="glass-input block w-full rounded-xl pr-10 pl-4 py-3 text-sm placeholder-slate-400">
                    </div>
                    @error('password')
                        <p class="text-xs text-rose-400 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-purple-500/30 bg-[#07090e] text-amber-500 focus:ring-amber-500 focus:ring-offset-0">
                        <span class="text-xs text-slate-300 select-none">تذكر تسجيل دخولي</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full inline-flex items-center justify-center gap-2 py-3.5 px-4 rounded-xl text-sm font-bold text-slate-950 bg-gradient-to-r from-amber-400 to-amber-300 hover:from-amber-300 hover:to-amber-200 shadow-xl shadow-amber-500/20 hover:scale-[1.01] transition-all">
                    <i data-lucide="log-in" class="w-4 h-4 stroke-[2.5]"></i>
                    <span>دخول إلى المنصة</span>
                </button>
            </form>

            <div class="mt-8 text-center text-xs text-slate-400 pt-6 border-t border-purple-500/15">
                ليس لديك حساب بعد؟
                <a href="{{ route('register') }}" class="text-amber-400 font-semibold hover:text-amber-300 transition-colors mr-1">
                    أنشئ حساباً جديداً
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
