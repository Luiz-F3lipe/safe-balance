@props(['class' => ''])

<div {{ $attributes->merge(['class' => "flex items-center gap-3 {$class}"]) }}>
    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-linear-to-br from-emerald-500 to-emerald-600 dark:from-emerald-600 dark:to-emerald-700 shadow-lg">
        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
    </div>
    <div class="flex flex-col">
        <span class="text-lg font-bold text-emerald-700 dark:text-emerald-400">Safe Balance</span>
        <span class="text-xs text-emerald-600/70 dark:text-emerald-500/70">Controle Financeiro</span>
    </div>
</div>
