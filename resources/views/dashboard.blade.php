@extends('layouts.app')

@section('title', 'لوحة التحكم')

@section('content')
<div class="space-y-8">
    <!-- Welcome Header & Quick Action -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 glass-panel p-6 sm:p-8 rounded-3xl border border-purple-500/20 bg-gradient-to-r from-purple-950/40 via-[#0e1424] to-[#0b0f19]">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-purple-600/20 border border-purple-500/30 text-amber-300 text-xs font-semibold mb-2">
                <i data-lucide="sparkles" class="w-3.5 h-3.5"></i>
                <span>كبسولتك الزمنية الشخصية</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white">مرحباً بك، {{ $user->name }} 👋</h1>
            <p class="text-xs sm:text-sm text-slate-300 mt-1">
                المنطقة الزمنية المعتمدة لحسابك: <span class="font-mono text-purple-300 font-semibold">{{ $user->timezone }}</span> (جميع التواريخ تحسب بدقة وفقاً لها).
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('capsules.create') }}" 
               class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl text-sm font-bold text-slate-950 bg-gradient-to-r from-amber-400 to-amber-300 hover:from-amber-300 hover:to-amber-200 shadow-xl shadow-amber-500/20 hover:scale-[1.02] transition-all">
                <i data-lucide="plus-circle" class="w-5 h-5"></i>
                <span>إنشاء كبسولة جديدة</span>
            </a>
        </div>
    </div>

    <!-- Statistics Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <a href="{{ route('capsules.index') }}" class="block">
            <x-stat-card 
                title="إجمالي الكبسولات" 
                :count="$stats['total']" 
                icon="box" 
                color="blue"
                description="جميع الكبسولات المسجلة" />
        </a>

        <a href="{{ route('capsules.closed') }}" class="block">
            <x-stat-card 
                title="الكبسولات المغلقة" 
                :count="$stats['closed']" 
                icon="lock" 
                color="purple"
                description="مغلقة حتى موعد فتحها" />
        </a>

        <a href="{{ route('capsules.ready') }}" class="block">
            <x-stat-card 
                title="متاحة للفتح الآن" 
                :count="$stats['ready']" 
                icon="key" 
                color="amber"
                description="حان موعد قراءتها" />
        </a>

        <a href="{{ route('capsules.index', ['tab' => 'opened']) }}" class="block">
            <x-stat-card 
                title="الكبسولات المفتوحة" 
                :count="$stats['opened']" 
                icon="book-open" 
                color="emerald"
                description="تم فتحها ومطالعتها" />
        </a>
    </div>

    <!-- Closest Next Capsule To Open (If Available) -->
    @if ($stats['next'])
        @php
            $next = $stats['next'];
            $nextOpenAt = $next->open_at->setTimezone($user->timezone)->format('Y/m/d H:i');
            $isoDate = $next->open_at->toIso8601String();
        @endphp
        <div class="glass-panel rounded-3xl p-6 sm:p-8 border border-amber-400/30 bg-gradient-to-b from-[#151c30] to-[#0d1322] relative overflow-hidden shadow-2xl">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                <div class="space-y-2">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-400/10 text-amber-300 border border-amber-400/30">
                        <i data-lucide="hourglass" class="w-3.5 h-3.5 text-amber-400"></i>
                        <span>أقرب كبسولة موعداً للفتح</span>
                    </div>
                    <h3 class="text-xl sm:text-2xl font-bold text-white">
                        <a href="{{ route('capsules.show', $next) }}" class="hover:text-amber-300 transition-colors">
                            {{ $next->title }}
                        </a>
                    </h3>
                    <p class="text-xs text-slate-300 max-w-xl">
                        {{ $next->description ?? 'لا يوجد وصف مختصر، المحتوى مشفر ومحمي داخل الكبسولة حتى انقضاء العداد.' }}
                    </p>
                    <div class="text-xs text-purple-300 font-mono pt-1">
                        تاريخ الاستحقاق: {{ $nextOpenAt }}
                    </div>
                </div>

                <!-- Real-time Countdown Box -->
                <div data-countdown="{{ $isoDate }}" class="bg-[#07090e]/80 border border-purple-500/30 rounded-2xl p-4 sm:p-5 text-center min-w-[280px]">
                    <span class="text-xs text-slate-400 block mb-2 font-medium">الوقت المتبقي لفتح هذه الكبسولة:</span>
                    <div class="cd-timer-grid grid grid-cols-4 gap-2 font-mono">
                        <div class="bg-[#111728] border border-purple-500/20 rounded-xl p-2">
                            <span class="cd-days block text-xl sm:text-2xl font-bold text-amber-300">00</span>
                            <span class="text-[10px] text-slate-400 font-sans">يوم</span>
                        </div>
                        <div class="bg-[#111728] border border-purple-500/20 rounded-xl p-2">
                            <span class="cd-hours block text-xl sm:text-2xl font-bold text-purple-200">00</span>
                            <span class="text-[10px] text-slate-400 font-sans">ساعة</span>
                        </div>
                        <div class="bg-[#111728] border border-purple-500/20 rounded-xl p-2">
                            <span class="cd-minutes block text-xl sm:text-2xl font-bold text-purple-200">00</span>
                            <span class="text-[10px] text-slate-400 font-sans">دقيقة</span>
                        </div>
                        <div class="bg-[#111728] border border-purple-500/20 rounded-xl p-2">
                            <span class="cd-seconds block text-xl sm:text-2xl font-bold text-amber-400">00</span>
                            <span class="text-[10px] text-slate-400 font-sans">ثانية</span>
                        </div>
                    </div>
                    <div class="cd-expired-notice hidden mt-3">
                        <a href="{{ route('capsules.show', $next) }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold bg-amber-400 text-black shadow-lg">
                            <i data-lucide="unlock" class="w-4 h-4"></i>
                            افتح الكبسولة الآن!
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Recent Capsules Section -->
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i data-lucide="clock-rewind" class="w-5 h-5 text-amber-400"></i>
                <h2 class="text-lg font-bold text-white">أحدث الكبسولات</h2>
            </div>
            <a href="{{ route('capsules.index') }}" class="text-xs text-amber-400 hover:text-amber-300 transition-colors font-medium">
                عرض جميع الكبسولات ({{ $stats['total'] }}) ←
            </a>
        </div>

        @if ($stats['recent']->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($stats['recent'] as $capsule)
                    <x-capsule-card :capsule="$capsule" />
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="glass-panel rounded-3xl p-12 text-center border border-purple-500/20">
                <div class="w-16 h-16 mx-auto rounded-3xl bg-purple-600/10 border border-purple-500/20 text-purple-300 flex items-center justify-center mb-4">
                    <i data-lucide="box" class="w-8 h-8"></i>
                </div>
                <h3 class="text-lg font-bold text-white mb-2">لا توجد لديك كبسولات زمنية بعد</h3>
                <p class="text-xs sm:text-sm text-slate-300 max-w-md mx-auto mb-6">
                    ابدأ الآن بكتابة رسالتك الأولى إلى نفسك، حدد موعد فتحها في المستقبل، وشاهد كيف ستكون مشاعرك حين تفتحها!
                </p>
                <a href="{{ route('capsules.create') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-bold text-slate-950 bg-gradient-to-r from-amber-400 to-amber-300 hover:from-amber-300 hover:to-amber-200 shadow-xl shadow-amber-500/20 transition-all">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    <span>إنشاء أول كبسولة الآن</span>
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
