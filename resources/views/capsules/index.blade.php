@extends('layouts.app')

@section('title', 'جميع الكبسولات الزمنية')

@section('content')
<div class="space-y-6">
    <!-- Header with Search & Filter -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white">كبسولاتي الزمنية</h1>
            <p class="text-xs sm:text-sm text-slate-300 mt-1">تصفح جميع الكبسولات والرسائل المحفوظة في رحلتك</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('capsules.create') }}" 
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold text-slate-950 bg-gradient-to-r from-amber-400 to-amber-300 hover:from-amber-300 hover:to-amber-200 shadow-md shadow-amber-500/20 hover:scale-[1.02] transition-all">
                <i data-lucide="plus" class="w-4 h-4 stroke-[2.5]"></i>
                <span>كبسولة جديدة</span>
            </a>
        </div>
    </div>

    <!-- Filters & Search Toolbar -->
    <div class="glass-panel p-4 rounded-2xl border border-purple-500/15 flex flex-col md:flex-row items-center justify-between gap-4">
        <!-- Tabs -->
        <div class="flex items-center gap-1.5 overflow-x-auto w-full md:w-auto pb-2 md:pb-0">
            <a href="{{ route('capsules.index', ['tab' => 'all', 'q' => $search]) }}" 
               class="px-4 py-2 rounded-xl text-xs font-semibold whitespace-nowrap transition-all {{ $currentTab === 'all' ? 'bg-amber-400 text-slate-950 shadow-md' : 'text-slate-300 hover:bg-white/5' }}">
                الكل
            </a>
            <a href="{{ route('capsules.index', ['tab' => 'closed', 'q' => $search]) }}" 
               class="px-4 py-2 rounded-xl text-xs font-semibold whitespace-nowrap transition-all {{ $currentTab === 'closed' ? 'bg-purple-600 text-white shadow-md' : 'text-slate-300 hover:bg-white/5' }}">
                <span class="flex items-center gap-1.5">
                    <i data-lucide="lock" class="w-3.5 h-3.5"></i>
                    الكبسولات المغلقة
                </span>
            </a>
            <a href="{{ route('capsules.index', ['tab' => 'ready', 'q' => $search]) }}" 
               class="px-4 py-2 rounded-xl text-xs font-semibold whitespace-nowrap transition-all {{ $currentTab === 'ready' ? 'bg-amber-500 text-slate-950 shadow-md' : 'text-slate-300 hover:bg-white/5' }}">
                <span class="flex items-center gap-1.5">
                    <i data-lucide="key" class="w-3.5 h-3.5"></i>
                    المتاحة للفتح
                </span>
            </a>
            <a href="{{ route('capsules.index', ['tab' => 'opened', 'q' => $search]) }}" 
               class="px-4 py-2 rounded-xl text-xs font-semibold whitespace-nowrap transition-all {{ $currentTab === 'opened' ? 'bg-emerald-600 text-white shadow-md' : 'text-slate-300 hover:bg-white/5' }}">
                <span class="flex items-center gap-1.5">
                    <i data-lucide="book-open" class="w-3.5 h-3.5"></i>
                    المفتوحة
                </span>
            </a>
        </div>

        <!-- Search input -->
        <form method="GET" action="{{ route('capsules.index') }}" class="w-full md:w-72 relative">
            <input type="hidden" name="tab" value="{{ $currentTab }}">
            <div class="relative">
                <input type="text" name="q" value="{{ $search }}" placeholder="ابحث بالعنوان أو الوصف..." 
                       class="glass-input w-full rounded-xl pr-9 pl-4 py-2 text-xs placeholder-slate-400">
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                    <i data-lucide="search" class="w-3.5 h-3.5"></i>
                </div>
                @if ($search)
                    <a href="{{ route('capsules.index', ['tab' => $currentTab]) }}" 
                       class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400 hover:text-white">
                        <i data-lucide="x" class="w-3.5 h-3.5"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Capsules Grid -->
    @if ($capsules->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($capsules as $capsule)
                <x-capsule-card :capsule="$capsule" />
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $capsules->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="glass-panel rounded-3xl p-12 text-center border border-purple-500/20 max-w-lg mx-auto">
            <div class="w-16 h-16 mx-auto rounded-3xl bg-purple-600/10 border border-purple-500/20 text-purple-300 flex items-center justify-center mb-4">
                <i data-lucide="search-x" class="w-8 h-8"></i>
            </div>
            <h3 class="text-base font-bold text-white mb-2">لم يتم العثور على أي كبسولات مطابقة</h3>
            <p class="text-xs text-slate-300 mb-6">
                @if ($search)
                    لا توجد نتائج بحث تطابق "<span class="text-amber-300">{{ $search }}</span>". حاول استخدام كلمات أخرى.
                @else
                    لا توجد كبسولات في هذا القسم حالياً.
                @endif
            </p>
            <a href="{{ route('capsules.create') }}" 
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold text-slate-950 bg-gradient-to-r from-amber-400 to-amber-300 hover:from-amber-300 hover:to-amber-200 transition-all shadow-md">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>إنشاء كبسولة جديدة</span>
            </a>
        </div>
    @endif
</div>
@endsection
