@extends('layouts.app')

@section('title', 'الكبسولات المتاحة للفتح')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-500/20 border border-amber-500/40 text-amber-300 text-xs font-semibold mb-2 animate-pulse">
                <i data-lucide="key" class="w-3.5 h-3.5 text-amber-400"></i>
                <span>جاهزة للقراءة والاكتشاف</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white">الكبسولات المتاحة للفتح</h1>
            <p class="text-xs sm:text-sm text-slate-300 mt-1">
                انقضى موعد قفل هذه الكبسولات، وحان الوقت لفتحها واسترجاع ذكرياتك.
            </p>
        </div>

        <a href="{{ route('capsules.index') }}" 
           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-medium text-slate-300 glass-panel hover:text-white transition-all">
            <i data-lucide="arrow-right" class="w-4 h-4"></i>
            <span>العودة لجميع الكبسولات</span>
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
            <div class="w-16 h-16 mx-auto rounded-3xl bg-amber-500/10 border border-amber-500/20 text-amber-300 flex items-center justify-center mb-4">
                <i data-lucide="clock" class="w-8 h-8"></i>
            </div>
            <h3 class="text-base font-bold text-white mb-2">لا توجد كبسولات جاهزة للفتح حالياً</h3>
            <p class="text-xs text-slate-300 mb-6">
                كبسولاتك لا تزال مغلقة ومحمية. يمكنك متابعة الوقت المتبقي في قسم الكبسولات المغلقة.
            </p>
            <a href="{{ route('capsules.closed') }}" 
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-semibold text-purple-200 bg-purple-600/30 border border-purple-500/30 hover:bg-purple-600/40 transition-all">
                <i data-lucide="lock" class="w-4 h-4"></i>
                <span>مشاهدة الكبسولات المغلقة</span>
            </a>
        </div>
    @endif
</div>
@endsection
