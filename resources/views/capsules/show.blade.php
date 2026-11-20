@extends('layouts.app')

@section('title', $capsule->title)

@php
    $userTimezone = auth()->user()->timezone ?? 'Asia/Aden';
    $createdAtFormatted = $capsule->created_at->setTimezone($userTimezone)->format('Y/m/d H:i');
    $openAtFormatted = $capsule->open_at->setTimezone($userTimezone)->format('Y/m/d H:i');
    $openedAtFormatted = $capsule->opened_at ? $capsule->opened_at->setTimezone($userTimezone)->format('Y/m/d H:i') : null;
    $isoOpenAt = $capsule->open_at->toIso8601String();
@endphp

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <!-- Breadcrumb & Navigation -->
    <div class="flex items-center justify-between text-xs text-slate-400">
        <div class="flex items-center gap-2">
            <a href="{{ route('capsules.index') }}" class="hover:text-amber-300 transition-colors">الكبسولات</a>
            <span>/</span>
            <span class="text-slate-200 truncate max-w-xs">{{ $capsule->title }}</span>
        </div>

        <div class="flex items-center gap-2">
            @if ($capsule->canBeDeleted())
                <button type="button" onclick="openModal('delete-modal-show')" 
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-rose-300 bg-rose-600/10 border border-rose-500/20 hover:bg-rose-600/20 transition-all">
                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                    <span>حذف</span>
                </button>
            @endif
        </div>
    </div>

    @if (session('celebrate'))
        <!-- Celebratory Banner -->
        <div class="p-6 rounded-3xl bg-gradient-to-r from-amber-500/20 via-purple-600/30 to-amber-500/20 border border-amber-400/40 text-center shadow-2xl relative overflow-hidden animate-pulse">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-amber-400 text-slate-950 mb-3 shadow-lg shadow-amber-500/30">
                <i data-lucide="party-popper" class="w-8 h-8"></i>
            </div>
            <h2 class="text-xl sm:text-2xl font-black text-amber-300 mb-1">تهانينا! حان الوقت لفتح كبسولتك</h2>
            <p class="text-xs sm:text-sm text-slate-200 max-w-lg mx-auto">
                لقد حفظت هذه الرسالة في الماضي، واليوم تلتقي بها من جديد. استمتع بقراءة ما كتبته لنفسك!
            </p>
        </div>
    @endif

    <!-- Capsule Main Container -->
    <div class="glass-panel rounded-3xl p-6 sm:p-10 border border-purple-500/25 bg-gradient-to-b from-[#111728]/95 to-[#0b0f19] shadow-2xl relative overflow-hidden">
        <!-- Top Status Bar -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-purple-500/20 pb-6 mb-8">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    @if (!$isReady)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-purple-500/15 text-purple-300 border border-purple-500/30">
                            <i data-lucide="lock" class="w-3.5 h-3.5 text-purple-400"></i>
                            <span>مغلقة ومحمية بالسيرفر</span>
                        </span>
                    @elseif (!$isOpened)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-500/20 text-amber-300 border border-amber-500/40 animate-pulse">
                            <i data-lucide="key" class="w-3.5 h-3.5 text-amber-400"></i>
                            <span>حان موعد الفتح الآن</span>
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/15 text-emerald-300 border border-emerald-500/30">
                            <i data-lucide="check-circle" class="w-3.5 h-3.5 text-emerald-400"></i>
                            <span>مفتوحة ومقروءة</span>
                        </span>
                    @endif

                    <span class="text-xs text-slate-400 font-mono">
                        أنشئت في: {{ $createdAtFormatted }}
                    </span>
                </div>

                <h1 class="text-2xl sm:text-4xl font-extrabold text-white leading-tight">
                    {{ $capsule->title }}
                </h1>

                @if ($capsule->description)
                    <p class="text-sm text-slate-300 mt-2 leading-relaxed">
                        {{ $capsule->description }}
                    </p>
                @endif
            </div>

            <!-- Date Metadata Card -->
            <div class="bg-[#07090e]/80 border border-purple-500/20 rounded-2xl p-4 text-xs font-mono space-y-1 sm:text-left text-right min-w-[200px]">
                <div class="text-slate-400">
                    <span class="text-purple-300">موعد الفتح:</span>
                    <span class="text-amber-300 font-bold block">{{ $openAtFormatted }}</span>
                </div>
                @if ($openedAtFormatted)
                    <div class="pt-1 text-slate-400 border-t border-purple-500/10">
                        <span class="text-emerald-400">فُتحت في:</span>
                        <span class="text-white block">{{ $openedAtFormatted }}</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- CONTENT SECTION: Locked Vault vs Unlocked Message -->
        @if (!$isReady)
            <!-- STATE 1: Capsule is strictly CLOSED and LOCKED -->
            <div class="text-center py-10 px-4 space-y-8">
                <!-- Glowing Lock Icon Animation -->
                <div class="relative inline-block">
                    <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-3xl bg-purple-950/80 border border-purple-500/40 flex items-center justify-center text-amber-400 shadow-2xl shadow-purple-900/50 mx-auto">
                        <i data-lucide="lock" class="w-12 h-12 stroke-[1.5]"></i>
                    </div>
                    <div class="absolute -top-1 -right-1 w-6 h-6 rounded-full bg-amber-400 text-slate-950 flex items-center justify-center text-xs font-bold animate-ping"></div>
                </div>

                <div class="max-w-md mx-auto">
                    <h2 class="text-xl sm:text-2xl font-bold text-white mb-2">محتوى الكبسولة مؤصد ومحمي</h2>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                        الرسالة والصور المرفقة مشفرة ومحفوظة في الخادم ولا يمكن إرجاعها إلى المتصفح حتى ينتهي العداد التنازلي ويحين الموعد تماماً.
                    </p>
                </div>

                <!-- Big Countdown Clock -->
                <div data-countdown="{{ $isoOpenAt }}" class="max-w-lg mx-auto">
                    <span class="block text-xs font-semibold text-purple-300 mb-3">الوقت المتبقي لفتح هذه الكبسولة:</span>
                    <div class="cd-timer-grid grid grid-cols-4 gap-3 font-mono text-center">
                        <div class="bg-[#07090e] border border-purple-500/30 rounded-2xl p-4 shadow-inner">
                            <span class="cd-days block text-2xl sm:text-4xl font-black text-amber-300">00</span>
                            <span class="text-xs text-slate-400 font-sans mt-1 block">يوماً</span>
                        </div>
                        <div class="bg-[#07090e] border border-purple-500/30 rounded-2xl p-4 shadow-inner">
                            <span class="cd-hours block text-2xl sm:text-4xl font-black text-purple-200">00</span>
                            <span class="text-xs text-slate-400 font-sans mt-1 block">ساعة</span>
                        </div>
                        <div class="bg-[#07090e] border border-purple-500/30 rounded-2xl p-4 shadow-inner">
                            <span class="cd-minutes block text-2xl sm:text-4xl font-black text-purple-200">00</span>
                            <span class="text-xs text-slate-400 font-sans mt-1 block">دقيقة</span>
                        </div>
                        <div class="bg-[#07090e] border border-purple-500/30 rounded-2xl p-4 shadow-inner">
                            <span class="cd-seconds block text-2xl sm:text-4xl font-black text-amber-400 animate-pulse">00</span>
                            <span class="text-xs text-slate-400 font-sans mt-1 block">ثانية</span>
                        </div>
                    </div>

                    <div class="cd-expired-notice hidden mt-6">
                        <button onclick="window.location.reload()" 
                                class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl text-sm font-bold bg-amber-400 text-slate-950 shadow-xl shadow-amber-500/30">
                            <i data-lucide="unlock" class="w-5 h-5"></i>
                            <span>حان موعد الفتح! اضغط هنا للتحديث والفتح</span>
                        </button>
                    </div>
                </div>

                <div class="pt-6 border-t border-purple-500/10 flex items-center justify-center gap-4 text-xs text-slate-400">
                    <span class="flex items-center gap-1.5">
                        <i data-lucide="shield-check" class="w-4 h-4 text-emerald-400"></i>
                        حماية أمنية مشددة (Backend Validation)
                    </span>
                    <span>•</span>
                    <span class="flex items-center gap-1.5">
                        <i data-lucide="clock" class="w-4 h-4 text-amber-400"></i>
                        توقيت {{ $userTimezone }}
                    </span>
                </div>
            </div>

        @elseif (!$isOpened)
            <!-- STATE 2: Capsule is READY to be opened, user hasn't clicked open yet -->
            <div class="text-center py-12 px-4 space-y-8">
                <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-3xl bg-amber-400/15 border border-amber-400/40 flex items-center justify-center text-amber-400 shadow-2xl shadow-amber-500/20 mx-auto animate-unlock-pulse">
                    <i data-lucide="key" class="w-12 h-12 stroke-[1.5]"></i>
                </div>

                <div class="max-w-md mx-auto">
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-white mb-2">حان الموعد المنتظر!</h2>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                        انقضى وقت الانتظار المحدد، وأصبحت كبسولتك الزمنية جاهزة لفك قفلها واسترجاع الذكريات.
                    </p>
                </div>

                <form method="POST" action="{{ route('capsules.open', $capsule) }}">
                    @csrf
                    <button type="submit" 
                            class="inline-flex items-center gap-3 px-8 py-4 rounded-2xl text-base sm:text-lg font-black text-slate-950 bg-gradient-to-r from-amber-400 via-amber-300 to-amber-200 hover:from-amber-300 hover:to-amber-100 shadow-2xl shadow-amber-500/30 hover:scale-105 transition-all">
                        <i data-lucide="unlock" class="w-6 h-6 stroke-[2.5]"></i>
                        <span>افتح الكبسولة واكشف الرسالة الآن</span>
                    </button>
                </form>
            </div>

        @else
            <!-- STATE 3: Capsule is OPENED and REVEALED -->
            <div class="space-y-8 py-2">
                <!-- Secret Message Container (Styled like a precious preserved manuscript) -->
                <div class="rounded-3xl p-6 sm:p-8 bg-[#07090e]/90 border border-purple-500/30 shadow-inner relative">
                    <div class="flex items-center justify-between pb-4 mb-4 border-b border-purple-500/20 text-xs text-purple-300">
                        <span class="flex items-center gap-2">
                            <i data-lucide="feather" class="w-4 h-4 text-amber-400"></i>
                            <span class="font-bold text-slate-200">الرسالة المسترجعة من الماضي:</span>
                        </span>
                        <span class="text-slate-400 font-mono">
                            بقيت مغلقة ومحمية حتى فتحتها
                        </span>
                    </div>

                    <!-- Revealed Message Text -->
                    <div class="prose prose-invert max-w-none text-slate-100 text-sm sm:text-base leading-loose whitespace-pre-line font-normal selection:bg-amber-400 selection:text-black">
                        {{ $messageContent }}
                    </div>
                </div>

                <!-- Attached Image if present -->
                @if ($imageUrl)
                    <div class="space-y-3">
                        <span class="block text-xs font-bold text-slate-300 flex items-center gap-2">
                            <i data-lucide="image" class="w-4 h-4 text-amber-400"></i>
                            الصورة التذكارية المرفقة:
                        </span>
                        <div class="rounded-3xl overflow-hidden border border-purple-500/30 bg-[#07090e] shadow-2xl max-w-2xl">
                            <img src="{{ $imageUrl }}" alt="{{ $capsule->title }}" class="w-full h-auto max-h-[500px] object-cover">
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>

    <!-- Delete Confirmation Modal (Show page) -->
    @if ($capsule->canBeDeleted())
        <div id="delete-modal-show" class="app-modal hidden fixed inset-0 z-50 items-center justify-center p-4 bg-black/70 backdrop-blur-sm">
            <div class="glass-panel bg-[#0d1322] border border-rose-500/30 rounded-2xl max-w-md w-full p-6 text-right shadow-2xl relative">
                <div class="w-12 h-12 rounded-2xl bg-rose-500/15 text-rose-400 flex items-center justify-center mb-4">
                    <i data-lucide="alert-triangle" class="w-6 h-6"></i>
                </div>
                <h4 class="text-base font-bold text-white mb-2">تأكيد حذف الكبسولة الزمنية</h4>
                <p class="text-xs text-slate-300 mb-6 leading-relaxed">
                    هل أنت متأكد من رغبتك في حذف كبسولة "<span class="text-amber-300 font-semibold">{{ $capsule->title }}</span>" نهائياً؟
                </p>
                <div class="flex items-center justify-end gap-3">
                    <button type="button" onclick="closeModal('delete-modal-show')" 
                            class="px-4 py-2 rounded-xl text-xs font-medium text-slate-300 hover:bg-white/5 transition-colors">
                        إلغاء
                    </button>
                    <form method="POST" action="{{ route('capsules.destroy', $capsule) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="px-4 py-2 rounded-xl text-xs font-semibold bg-rose-600 hover:bg-rose-500 text-white shadow-lg shadow-rose-600/30 transition-all">
                            تأكيد الحذف
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
