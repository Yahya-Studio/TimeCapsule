@extends('layouts.app')

@section('title', 'الكبسولات المغلقة')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-purple-600/20 border border-purple-500/30 text-purple-300 text-xs font-semibold mb-2">
                <i data-lucide="lock" class="w-3.5 h-3.5 text-purple-400"></i>
                <span>خزنة الذكريات المؤصدة</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white">الكبسولات المغلقة</h1>
            <p class="text-xs sm:text-sm text-slate-300 mt-1">
                جميع هذه الكبسولات محمية ومغلقة بإحكام حتى يحين موعد فتحها المحدد مستقبلاً.
            </p>
        </div>

        <a href="{{ route('capsules.create') }}" 
           class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold text-slate-950 bg-gradient-to-r from-amber-400 to-amber-300 hover:from-amber-300 hover:to-amber-200 shadow-md shadow-amber-500/20 hover:scale-[1.02] transition-all">
            <i data-lucide="plus" class="w-4 h-4 stroke-[2.5]"></i>
            <span>إغلاق كبسولة جديدة</span>
        </a>
    </div>

    @if ($capsules->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($capsules as $capsule)
                <x-capsule-card :capsule="$capsule" />
            @endforeach
        </div>

        <div class="mt-8">
            {{ $capsules->links() }}
        </div>
    @else
        <div class="glass-panel rounded-3xl p-12 text-center border border-purple-500/20 max-w-lg mx-auto">
            <div class="w-16 h-16 mx-auto rounded-3xl bg-purple-600/10 border border-purple-500/20 text-purple-300 flex items-center justify-center mb-4">
                <i data-lucide="lock" class="w-8 h-8"></i>
            </div>
            <h3 class="text-base font-bold text-white mb-2">لا توجد كبسولات مغلقة حالياً</h3>
            <p class="text-xs text-slate-300 mb-6">
                قم بإنشاء كبسولة جديدة الآن وحدد موعداً مستقبلياً لقفلها ومشاهدة عدادها التنازلي.
            </p>
            <a href="{{ route('capsules.create') }}" 
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold text-slate-950 bg-gradient-to-r from-amber-400 to-amber-300 hover:from-amber-300 hover:to-amber-200 transition-all shadow-md">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>إنشاء كبسولة الآن</span>
            </a>
        </div>
    @endif
</div>
@endsection
