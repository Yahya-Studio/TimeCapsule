@extends('layouts.app')

@section('title', 'الإعدادات العامة')

@section('content')
<div class="max-w-3xl mx-auto space-y-8">
    <div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-white">الإعدادات العامة</h1>
        <p class="text-xs sm:text-sm text-slate-300 mt-1">تخصيص تفضيلات الحساب، والمنطقة الزمنية، وإحصائيات الاستخدام</p>
    </div>

    <!-- Account Overview Card -->
    <div class="glass-panel rounded-3xl p-6 sm:p-8 border border-purple-500/20 bg-gradient-to-b from-[#111728]/95 to-[#0b0f19]">
        <h3 class="text-base font-bold text-white mb-4 flex items-center gap-2">
            <i data-lucide="shield" class="w-5 h-5 text-amber-400"></i>
            <span>معلومات الحساب والأمان</span>
        </h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
            <div class="p-4 rounded-2xl bg-[#07090e] border border-purple-500/15">
                <span class="text-slate-400 block mb-1">اسم المستخدم:</span>
                <span class="font-bold text-white text-sm">{{ $user->name }}</span>
            </div>
            <div class="p-4 rounded-2xl bg-[#07090e] border border-purple-500/15">
                <span class="text-slate-400 block mb-1">البريد الإلكتروني:</span>
                <span class="font-bold text-white text-sm">{{ $user->email }}</span>
            </div>
            <div class="p-4 rounded-2xl bg-[#07090e] border border-purple-500/15">
                <span class="text-slate-400 block mb-1">إجمالي الكبسولات المخزنة:</span>
                <span class="font-bold text-amber-400 text-sm font-mono">{{ $capsulesCount }} كبسولة</span>
            </div>
            <div class="p-4 rounded-2xl bg-[#07090e] border border-purple-500/15">
                <span class="text-slate-400 block mb-1">تاريخ الانضمام:</span>
                <span class="font-bold text-white text-sm font-mono">{{ $user->created_at->format('Y/m/d') }}</span>
            </div>
        </div>
    </div>

    <!-- Timezone & Preferences Settings Form -->
    <div class="glass-panel rounded-3xl p-6 sm:p-8 border border-purple-500/20 bg-gradient-to-b from-[#111728]/95 to-[#0b0f19]">
        <h3 class="text-base font-bold text-white mb-2 flex items-center gap-2">
            <i data-lucide="globe" class="w-5 h-5 text-purple-400"></i>
            <span>المنطقة الزمنية والتوقيت</span>
        </h3>
        <p class="text-xs text-slate-300 mb-6">
            يعتمد نظام TimeCapsule على منطقتك الزمنية المحددة لحساب موعد فتح كل كبسولة وتقديم عداد تنازلي دقيق.
        </p>

        <form method="POST" action="{{ route('settings.update') }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="settings-timezone" class="block text-xs font-semibold text-slate-200 mb-2">اختر المنطقة الزمنية</label>
                <select id="settings-timezone" name="timezone" class="glass-input block w-full rounded-xl px-4 py-3 text-sm bg-[#0b0f19]">
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

            <div class="pt-4 flex justify-end">
                <button type="submit" 
                        class="px-6 py-3 rounded-xl text-xs font-bold text-slate-950 bg-gradient-to-r from-amber-400 to-amber-300 hover:from-amber-300 hover:to-amber-200 transition-all shadow-md">
                    حفظ تفضيلات التوقيت
                </button>
            </div>
        </form>
    </div>

    <!-- Security & Data Principles -->
    <div class="glass-panel rounded-3xl p-6 sm:p-8 border border-purple-500/20 bg-gradient-to-b from-[#111728]/95 to-[#0b0f19]">
        <h3 class="text-base font-bold text-white mb-2 flex items-center gap-2">
            <i data-lucide="lock" class="w-5 h-5 text-emerald-400"></i>
            <span>ميثاق خصوصية TimeCapsule</span>
        </h3>
        <ul class="text-xs text-slate-300 space-y-2 leading-relaxed">
            <li class="flex items-start gap-2">
                <i data-lucide="check" class="w-4 h-4 text-emerald-400 shrink-0 mt-0.5"></i>
                <span>رسائلك وذكرياتك ملك لك وحدك؛ لا يمكن لأي مستخدم آخر أو محرك بحث الوصول إليها.</span>
            </li>
            <li class="flex items-start gap-2">
                <i data-lucide="check" class="w-4 h-4 text-emerald-400 shrink-0 mt-0.5"></i>
                <span>يتم حجب محتوى الكبسولة على مستوى الخادم بشكل برمجي صارم حتى حلول الموعد.</span>
            </li>
            <li class="flex items-start gap-2">
                <i data-lucide="check" class="w-4 h-4 text-emerald-400 shrink-0 mt-0.5"></i>
                <span>يمكنك حذف كبسولتك غير المفتوحة نهائياً في أي وقت بضغطة زر.</span>
            </li>
        </ul>
    </div>
</div>
@endsection
