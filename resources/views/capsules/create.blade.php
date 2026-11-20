@extends('layouts.app')

@section('title', 'إنشاء كبسولة زمنية جديدة')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-400/10 border border-amber-400/30 text-amber-300 text-xs font-semibold mb-2">
            <i data-lucide="sparkles" class="w-3.5 h-3.5 text-amber-400"></i>
            <span>تخليد لحظة للمستقبل</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-white">إنشاء كبسولة زمنية جديدة</h1>
        <p class="text-xs sm:text-sm text-slate-300 mt-1">
            اكتب رسالتك، أرفق ذكرياتك، وحدد متى ترغب في أن تفتحها وتقرأها مرة أخرى.
        </p>
    </div>

    <!-- Main Card -->
    <div class="glass-panel rounded-3xl p-6 sm:p-10 border border-purple-500/20 bg-gradient-to-b from-[#111728]/95 to-[#0b0f19] shadow-2xl relative">
        <form method="POST" action="{{ route('capsules.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Title -->
            <div>
                <label for="title" class="block text-xs font-bold text-slate-200 mb-2">
                    عنوان الكبسولة <span class="text-amber-400">*</span>
                </label>
                <input id="title" type="text" name="title" value="{{ old('title') }}" required autofocus
                       placeholder="مثال: رسالة لنفسي بعد التخرج، أهدافي لعام 2027، ذكرى يوم مميز..."
                       class="glass-input block w-full rounded-xl px-4 py-3 text-sm placeholder-slate-400">
                @error('title')
                    <p class="text-xs text-rose-400 mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description (Optional) -->
            <div>
                <label for="description" class="block text-xs font-bold text-slate-200 mb-2">
                    وصف مختصر <span class="text-slate-400 font-normal">(اختياري - يظهر على البطاقة من الخارج)</span>
                </label>
                <input id="description" type="text" name="description" value="{{ old('description') }}"
                       placeholder="تلميح بسيط أو فكرة عامة عن محتوى الكبسولة دون حرق التفاصيل..."
                       class="glass-input block w-full rounded-xl px-4 py-3 text-sm placeholder-slate-400">
                @error('description')
                    <p class="text-xs text-rose-400 mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <!-- Message (Secret Content) -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label for="message" class="block text-xs font-bold text-slate-200">
                        نص الرسالة أو الذكرى السرية <span class="text-amber-400">*</span>
                    </label>
                    <span class="inline-flex items-center gap-1 text-[11px] text-purple-300">
                        <i data-lucide="lock" class="w-3 h-3 text-amber-400"></i>
                        مشفر ومحمي حتى موعد الفتح
                    </span>
                </div>
                <textarea id="message" name="message" rows="8" required
                          placeholder="اكتب كل ما تريد إخباره لنفسك في المستقبل: مشاعرك الحالية، أفكارك، التحديات التي تمر بها، توقعاتك، ونصائحك لذاتك المستقبلية..."
                          class="glass-input block w-full rounded-xl p-4 text-sm placeholder-slate-400 leading-relaxed">{{ old('message') }}</textarea>
                @error('message')
                    <p class="text-xs text-rose-400 mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <!-- Image Upload (Optional) -->
            <div>
                <label for="image" class="block text-xs font-bold text-slate-200 mb-2">
                    صورة تذكارية مرفقة <span class="text-slate-400 font-normal">(اختياري - حجم أقصى 5 ميجابايت)</span>
                </label>
                <div class="border-2 border-dashed border-purple-500/25 rounded-2xl p-4 sm:p-6 text-center hover:border-amber-400/50 transition-all bg-[#07090e]/60">
                    <div class="flex flex-col items-center justify-center">
                        <i data-lucide="image-plus" class="w-8 h-8 text-purple-400 mb-2"></i>
                        <label for="image" class="cursor-pointer text-xs font-semibold text-amber-300 hover:text-amber-200">
                            انقر لاختيار صورة من جهازك
                            <input id="image" type="file" name="image" accept="image/*" class="sr-only" onchange="document.getElementById('file-chosen-name').textContent = this.files[0] ? this.files[0].name : ''">
                        </label>
                        <p class="text-[11px] text-slate-400 mt-1">يدعم JPG, PNG, WEBP, GIF حتى 5MB</p>
                        <span id="file-chosen-name" class="text-xs font-mono text-purple-300 mt-2 block font-semibold"></span>
                    </div>
                </div>
                @error('image')
                    <p class="text-xs text-rose-400 mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <!-- Open Date & Time Section -->
            <div class="p-6 rounded-2xl bg-purple-950/20 border border-purple-500/25 space-y-4">
                <div class="flex items-center gap-2">
                    <i data-lucide="calendar-clock" class="w-5 h-5 text-amber-400"></i>
                    <div>
                        <h3 class="text-sm font-bold text-white">تحديد موعد فتح الكبسولة</h3>
                        <p class="text-[11px] text-slate-300">يجب أن يكون التاريخ في المستقبل (حسب توقيت {{ auth()->user()->timezone }})</p>
                    </div>
                </div>

                <!-- Quick Date Selection Shortcuts -->
                <div>
                    <span class="block text-[11px] font-medium text-slate-400 mb-2">خيارات سريعة للاختيار:</span>
                    <div class="flex flex-wrap gap-2">
                        <button type="button" onclick="setQuickDate(1)" 
                                class="quick-date-btn px-3 py-1.5 rounded-lg text-xs font-medium border border-purple-500/30 text-purple-200 hover:bg-white/5 transition-colors">
                            بعد شهر واحد
                        </button>
                        <button type="button" onclick="setQuickDate(3)" 
                                class="quick-date-btn px-3 py-1.5 rounded-lg text-xs font-medium border border-purple-500/30 text-purple-200 hover:bg-white/5 transition-colors">
                            بعد 3 أشهر
                        </button>
                        <button type="button" onclick="setQuickDate(6)" 
                                class="quick-date-btn px-3 py-1.5 rounded-lg text-xs font-medium border border-purple-500/30 text-purple-200 hover:bg-white/5 transition-colors">
                            بعد 6 أشهر
                        </button>
                        <button type="button" onclick="setQuickDate(12)" 
                                class="quick-date-btn px-3 py-1.5 rounded-lg text-xs font-medium border border-purple-500/30 text-purple-200 hover:bg-white/5 transition-colors">
                            بعد سنة كاملة
                        </button>
                        <button type="button" onclick="setQuickDate(36)" 
                                class="quick-date-btn px-3 py-1.5 rounded-lg text-xs font-medium border border-purple-500/30 text-purple-200 hover:bg-white/5 transition-colors">
                            بعد 3 سنوات
                        </button>
                    </div>
                </div>

                <!-- Date & Time inputs -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                    <div>
                        <label for="open_date" class="block text-xs font-semibold text-slate-200 mb-2">تاريخ الفتح (يوم/شهر/سنة)</label>
                        <input id="open_date" type="date" name="open_date" value="{{ old('open_date', $defaultDate) }}" required
                               min="{{ date('Y-m-d') }}"
                               class="glass-input block w-full rounded-xl px-4 py-2.5 text-sm">
                        @error('open_date')
                            <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="open_time" class="block text-xs font-semibold text-slate-200 mb-2">وقت الفتح</label>
                        <input id="open_time" type="time" name="open_time" value="{{ old('open_time', $defaultTime) }}" required
                               class="glass-input block w-full rounded-xl px-4 py-2.5 text-sm">
                        @error('open_time')
                            <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                @error('open_datetime')
                    <p class="text-xs text-rose-400 font-semibold bg-rose-500/10 p-2.5 rounded-xl border border-rose-500/30 mt-2">
                        ⚠️ {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end gap-4 pt-4 border-t border-purple-500/15">
                <a href="{{ route('capsules.index') }}" 
                   class="px-5 py-3 rounded-xl text-xs font-medium text-slate-300 hover:bg-white/5 transition-colors">
                    إلغاء والعودة
                </a>

                <button type="submit" 
                        class="inline-flex items-center gap-2 px-6 py-3.5 rounded-xl text-sm font-bold text-slate-950 bg-gradient-to-r from-amber-400 to-amber-300 hover:from-amber-300 hover:to-amber-200 shadow-xl shadow-amber-500/25 hover:scale-[1.01] transition-all">
                    <i data-lucide="lock" class="w-4 h-4 stroke-[2.5]"></i>
                    <span>إغلاق وحفظ الكبسولة الزمنية</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
