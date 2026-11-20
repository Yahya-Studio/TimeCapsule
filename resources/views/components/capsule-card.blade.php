@props(['capsule'])

@php
    $userTimezone = auth()->user()->timezone ?? 'Asia/Aden';
    $createdAtFormatted = $capsule->created_at->setTimezone($userTimezone)->format('Y/m/d H:i');
    $openAtFormatted = $capsule->open_at->setTimezone($userTimezone)->format('Y/m/d H:i');
    $isoOpenAt = $capsule->open_at->toIso8601String();
    $status = $capsule->status_code; // 'closed', 'ready', 'opened'
@endphp

<div class="glass-panel glass-panel-hover rounded-2xl p-5 sm:p-6 flex flex-col justify-between border relative overflow-hidden group">
    <!-- Status Corner Accent -->
    @if ($status === 'closed')
        <div class="absolute top-0 right-0 w-24 h-24 bg-purple-600/10 rounded-full blur-xl pointer-events-none"></div>
    @elseif ($status === 'ready')
        <div class="absolute top-0 right-0 w-24 h-24 bg-amber-500/15 rounded-full blur-xl pointer-events-none"></div>
    @else
        <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-500/10 rounded-full blur-xl pointer-events-none"></div>
    @endif

    <div>
        <!-- Card Top Bar: Status Badge & Lock Icon -->
        <div class="flex items-center justify-between gap-3 mb-4">
            @if ($status === 'closed')
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-purple-500/15 text-purple-300 border border-purple-500/30">
                    <i data-lucide="lock" class="w-3.5 h-3.5 text-purple-400"></i>
                    <span>مغلقة ومحمية</span>
                </span>
            @elseif ($status === 'ready')
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-500/20 text-amber-300 border border-amber-500/40 animate-pulse">
                    <i data-lucide="key" class="w-3.5 h-3.5 text-amber-400"></i>
                    <span>متاحة للفتح الآن</span>
                </span>
            @else
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/15 text-emerald-300 border border-emerald-500/30">
                    <i data-lucide="check-circle" class="w-3.5 h-3.5 text-emerald-400"></i>
                    <span>تم فتحها ومراجعتها</span>
                </span>
            @endif

            <span class="text-[11px] text-slate-400 font-mono">
                {{ $createdAtFormatted }}
            </span>
        </div>

        <!-- Title & Description -->
        <h3 class="text-lg font-bold text-white group-hover:text-amber-300 transition-colors mb-2 line-clamp-1">
            <a href="{{ route('capsules.show', $capsule) }}">
                {{ $capsule->title }}
            </a>
        </h3>

        @if ($capsule->description)
            <p class="text-xs text-slate-300 line-clamp-2 mb-4 leading-relaxed">
                {{ $capsule->description }}
            </p>
        @else
            <p class="text-xs text-slate-400 italic mb-4">
                بدون وصف مختصر.
            </p>
        @endif
    </div>

    <!-- Middle Info: Countdown or Unlock notice -->
    <div class="my-4 pt-3 border-t border-purple-500/15">
        @if ($status === 'closed')
            <!-- Live Countdown Timer Component -->
            <div data-countdown="{{ $isoOpenAt }}" class="capsule-countdown">
                <div class="flex items-center justify-between text-xs text-slate-400 mb-2">
                    <span class="flex items-center gap-1">
                        <i data-lucide="clock" class="w-3.5 h-3.5 text-amber-400"></i>
                        الوقت المتبقي للفتح:
                    </span>
                    <span class="text-[11px] text-purple-300 font-mono">{{ $openAtFormatted }}</span>
                </div>

                <div class="cd-timer-grid grid grid-cols-4 gap-1.5 text-center font-mono">
                    <div class="bg-[#0b0f19] border border-purple-500/20 rounded-lg py-1.5 px-1">
                        <span class="cd-days block text-sm font-bold text-amber-300">00</span>
                        <span class="text-[9px] text-slate-400 font-sans">يوم</span>
                    </div>
                    <div class="bg-[#0b0f19] border border-purple-500/20 rounded-lg py-1.5 px-1">
                        <span class="cd-hours block text-sm font-bold text-purple-200">00</span>
                        <span class="text-[9px] text-slate-400 font-sans">ساعة</span>
                    </div>
                    <div class="bg-[#0b0f19] border border-purple-500/20 rounded-lg py-1.5 px-1">
                        <span class="cd-minutes block text-sm font-bold text-purple-200">00</span>
                        <span class="text-[9px] text-slate-400 font-sans">دقيقة</span>
                    </div>
                    <div class="bg-[#0b0f19] border border-purple-500/20 rounded-lg py-1.5 px-1">
                        <span class="cd-seconds block text-sm font-bold text-amber-400">00</span>
                        <span class="text-[9px] text-slate-400 font-sans">ثانية</span>
                    </div>
                </div>

                <div class="cd-expired-notice hidden mt-2 text-center">
                    <span class="inline-flex items-center gap-1 text-xs text-amber-300 font-medium">
                        <i data-lucide="unlock" class="w-3.5 h-3.5"></i>
                        حان موعد الفتح! حدّث الصفحة لفتحها.
                    </span>
                </div>
            </div>
        @elseif ($status === 'ready')
            <div class="p-3 rounded-xl bg-amber-500/10 border border-amber-500/30 text-center">
                <p class="text-xs font-semibold text-amber-300 flex items-center justify-center gap-1.5">
                    <i data-lucide="gift" class="w-4 h-4 text-amber-400"></i>
                    رسالتك جاهزة للاكتشاف وقراءتها الآن!
                </p>
                <span class="text-[11px] text-slate-400 block mt-1">تاريخ الاستحقاق: {{ $openAtFormatted }}</span>
            </div>
        @else
            <div class="p-3 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-center">
                <p class="text-xs font-medium text-emerald-300 flex items-center justify-center gap-1.5">
                    <i data-lucide="book-open" class="w-4 h-4 text-emerald-400"></i>
                    تم فتحها في {{ $capsule->opened_at->setTimezone($userTimezone)->format('Y/m/d H:i') }}
                </p>
            </div>
        @endif
    </div>

    <!-- Bottom Actions -->
    <div class="flex items-center justify-between gap-2 pt-3 border-t border-purple-500/10 mt-auto">
        <a href="{{ route('capsules.show', $capsule) }}" 
           class="inline-flex items-center gap-1.5 text-xs font-medium text-slate-300 hover:text-amber-300 transition-colors">
            <i data-lucide="eye" class="w-3.5 h-3.5"></i>
            <span>التفاصيل</span>
        </a>

        <div class="flex items-center gap-1.5">
            @if ($status === 'ready')
                <form method="POST" action="{{ route('capsules.open', $capsule) }}" class="inline">
                    @csrf
                    <button type="submit" 
                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-semibold text-slate-950 bg-amber-400 hover:bg-amber-300 transition-all shadow-md shadow-amber-500/20">
                        <i data-lucide="unlock" class="w-3.5 h-3.5"></i>
                        <span>افتح الآن</span>
                    </button>
                </form>
            @endif


            @if ($capsule->canBeDeleted())
                <button type="button" 
                        onclick="openModal('delete-modal-{{ $capsule->id }}')" 
                        title="حذف الكبسولة"
                        class="p-1.5 rounded-lg text-slate-400 hover:text-rose-400 hover:bg-rose-500/10 transition-all">
                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                </button>

                <!-- Delete Confirmation Modal -->
                <div id="delete-modal-{{ $capsule->id }}" class="app-modal hidden fixed inset-0 z-50 items-center justify-center p-4 bg-black/70 backdrop-blur-sm">
                    <div class="glass-panel bg-[#0d1322] border border-rose-500/30 rounded-2xl max-w-md w-full p-6 text-right shadow-2xl relative">
                        <div class="w-12 h-12 rounded-2xl bg-rose-500/15 text-rose-400 flex items-center justify-center mb-4">
                            <i data-lucide="alert-triangle" class="w-6 h-6"></i>
                        </div>
                        <h4 class="text-base font-bold text-white mb-2">هل أنت متأكد من حذف هذه الكبسولة؟</h4>
                        <p class="text-xs text-slate-300 mb-6 leading-relaxed">
                            سيتم حذف كبسولة "<span class="text-amber-300 font-semibold">{{ $capsule->title }}</span>" نهائياً ولن تتمكن من استرجاع ذكرياتها أو رسالتها بعد الحذف.
                        </p>
                        <div class="flex items-center justify-end gap-3">
                            <button type="button" onclick="closeModal('delete-modal-{{ $capsule->id }}')" 
                                    class="px-4 py-2 rounded-xl text-xs font-medium text-slate-300 hover:bg-white/5 transition-colors">
                                إلغاء
                            </button>
                            <form method="POST" action="{{ route('capsules.destroy', $capsule) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="px-4 py-2 rounded-xl text-xs font-semibold bg-rose-600 hover:bg-rose-500 text-white shadow-lg shadow-rose-600/30 transition-all">
                                    تأكيد الحذف النهائي
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
