@props(['title', 'count', 'icon', 'color' => 'purple', 'description' => null])

@php
    $colorClasses = match ($color) {
        'amber' => [
            'bg' => 'bg-amber-500/10 border-amber-500/20',
            'icon_bg' => 'bg-amber-500/20 text-amber-400',
            'text' => 'text-amber-400',
        ],
        'emerald' => [
            'bg' => 'bg-emerald-500/10 border-emerald-500/20',
            'icon_bg' => 'bg-emerald-500/20 text-emerald-400',
            'text' => 'text-emerald-400',
        ],
        'blue' => [
            'bg' => 'bg-blue-500/10 border-blue-500/20',
            'icon_bg' => 'bg-blue-500/20 text-blue-400',
            'text' => 'text-blue-400',
        ],
        default => [
            'bg' => 'bg-purple-600/10 border-purple-500/20',
            'icon_bg' => 'bg-purple-600/20 text-purple-400',
            'text' => 'text-purple-300',
        ],
    };
@endphp

<div class="glass-panel rounded-2xl p-5 border {{ $colorClasses['bg'] }} relative overflow-hidden transition-all hover:scale-[1.01]">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-xs font-medium text-slate-400 mb-1">{{ $title }}</p>
            <h3 class="text-2xl sm:text-3xl font-extrabold text-white font-mono">{{ $count }}</h3>
            @if ($description)
                <p class="text-[11px] text-slate-400 mt-1">{{ $description }}</p>
            @endif
        </div>
        <div class="w-12 h-12 rounded-2xl {{ $colorClasses['icon_bg'] }} flex items-center justify-center shadow-inner">
            <i data-lucide="{{ $icon }}" class="w-6 h-6"></i>
        </div>
    </div>
</div>
