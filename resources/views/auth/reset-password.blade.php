@extends('layouts.guest')

@section('title', 'تعيين كلمة مرور جديدة')

@section('content')
<div class="min-h-[calc(100vh-160px)] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        <div class="glass-panel rounded-3xl p-8 sm:p-10 border border-purple-500/25 shadow-2xl relative overflow-hidden bg-gradient-to-b from-[#111728]/95 to-[#0b0f19]">
            <div class="text-center mb-8">
                <div class="w-14 h-14 mx-auto rounded-2xl bg-amber-400/10 border border-amber-400/25 flex items-center justify-center text-amber-400 mb-4 shadow-lg shadow-amber-500/10">
                    <i data-lucide="lock" class="w-7 h-7"></i>
                </div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-white">كلمة مرور جديدة</h2>
                <p class="text-xs sm:text-sm text-slate-300 mt-2">أدخل كلمة المرور الجديدة لتأمين حسابك</p>
            </div>

            <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-200 mb-2">البريد الإلكتروني</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $email) }}" required
                           class="glass-input block w-full rounded-xl px-4 py-3 text-sm placeholder-slate-400">
                    @error('email')
                        <p class="text-xs text-rose-400 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-xs font-semibold text-slate-200 mb-2">كلمة المرور الجديدة</label>
                    <input id="password" type="password" name="password" required
                           placeholder="8 أحرف على الأقل"
                           class="glass-input block w-full rounded-xl px-4 py-3 text-sm placeholder-slate-400">
                    @error('password')
                        <p class="text-xs text-rose-400 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs font-semibold text-slate-200 mb-2">تأكيد كلمة المرور</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                           placeholder="أعد كتابة كلمة المرور"
                           class="glass-input block w-full rounded-xl px-4 py-3 text-sm placeholder-slate-400">
                </div>

                <div class="pt-3">
                    <button type="submit" 
                            class="w-full inline-flex items-center justify-center gap-2 py-3.5 px-4 rounded-xl text-sm font-bold text-slate-950 bg-gradient-to-r from-amber-400 to-amber-300 hover:from-amber-300 hover:to-amber-200 shadow-xl shadow-amber-500/20 hover:scale-[1.01] transition-all">
                        <i data-lucide="check-circle" class="w-4 h-4 stroke-[2.5]"></i>
                        <span>حفظ كلمة المرور الجديدة</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
