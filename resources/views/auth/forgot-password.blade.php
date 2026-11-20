@extends('layouts.guest')

@section('title', 'استعادة كلمة المرور')

@section('content')
<div class="min-h-[calc(100vh-160px)] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        <div class="glass-panel rounded-3xl p-8 sm:p-10 border border-purple-500/25 shadow-2xl relative overflow-hidden bg-gradient-to-b from-[#111728]/95 to-[#0b0f19]">
            <div class="text-center mb-8">
                <div class="w-14 h-14 mx-auto rounded-2xl bg-amber-400/10 border border-amber-400/25 flex items-center justify-center text-amber-400 mb-4 shadow-lg shadow-amber-500/10">
                    <i data-lucide="help-circle" class="w-7 h-7"></i>
                </div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-white">استعادة كلمة المرور</h2>
                <p class="text-xs sm:text-sm text-slate-300 mt-2">أدخل بريدك الإلكتروني لإعادة تعيين كلمة المرور</p>
            </div>

            @if (session('status'))
                <div class="p-4 mb-6 rounded-2xl bg-purple-900/30 border border-purple-500/30 text-purple-200 text-xs">
                    <p class="font-medium mb-2">{{ session('status') }}</p>
                    @if (session('reset_token'))
                        <div class="mt-3 p-3 bg-black/40 rounded-xl border border-amber-500/30 text-amber-300 text-right">
                            <span class="block text-[11px] text-slate-400 mb-1">رابط مباشر لإعادة التعيين:</span>
                            <a href="{{ route('password.reset', ['token' => session('reset_token'), 'email' => session('reset_email')]) }}" 
                               class="underline font-bold text-xs break-all hover:text-white">
                                اضغط هنا لإعادة تعيين كلمة المرور الآن
                            </a>
                        </div>
                    @endif
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-200 mb-2">البريد الإلكتروني المسجل</label>
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

                <button type="submit" 
                        class="w-full inline-flex items-center justify-center gap-2 py-3.5 px-4 rounded-xl text-sm font-bold text-slate-950 bg-gradient-to-r from-amber-400 to-amber-300 hover:from-amber-300 hover:to-amber-200 shadow-xl shadow-amber-500/20 hover:scale-[1.01] transition-all">
                    <i data-lucide="send" class="w-4 h-4 stroke-[2.5]"></i>
                    <span>إرسال رابط الاستعادة</span>
                </button>
            </form>

            <div class="mt-8 text-center text-xs text-slate-400 pt-6 border-t border-purple-500/15">
                تذكرت كلمة المرور؟
                <a href="{{ route('login') }}" class="text-amber-400 font-semibold hover:text-amber-300 transition-colors mr-1">
                    العودة لتسجيل الدخول
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
