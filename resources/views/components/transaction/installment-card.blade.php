@props(['installment'])

@php
    $isIncome = $installment->transaction->category->type === 'income';
    $bgColor = $isIncome
        ? 'bg-emerald-50 dark:bg-emerald-950/30 border-emerald-200 dark:border-emerald-800'
        : 'bg-red-50 dark:bg-red-950/30 border-red-200 dark:border-red-800';
    $iconColor = $isIncome
        ? 'text-emerald-600 dark:text-emerald-400 bg-emerald-100 dark:bg-emerald-900/50'
        : 'text-red-600 dark:text-red-400 bg-red-100 dark:bg-red-900/50';
    $textColor = $isIncome
        ? 'text-emerald-700 dark:text-emerald-400'
        : 'text-red-700 dark:text-red-400';
    $icon = $isIncome ? 'lucide.arrow-down-left' : 'lucide.arrow-up-right';
@endphp

<div class="border {{ $bgColor }} rounded-lg sm:rounded-xl p-3 sm:p-4 hover:shadow-md dark:hover:shadow-emerald-900/20 transition-shadow">
    <div class="flex items-start gap-2 sm:gap-3">
        {{-- Ícone --}}
        <div class="shrink-0">
            <div class="{{ $iconColor }} w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center">
                <x-icon name="{{ $icon }}" class="w-5 h-5 sm:w-6 sm:h-6" />
            </div>
        </div>

        {{-- Conteúdo --}}
        <div class="flex-1 min-w-0">
            {{-- Categoria --}}
            <h4 class="font-semibold text-gray-900 dark:text-gray-100 text-sm sm:text-base mb-0.5 sm:mb-1">
                {{ $installment->transaction->category->description }}
            </h4>

            {{-- Descrição da transação --}}
            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mb-1.5 sm:mb-2 line-clamp-1">
                {{ $installment->transaction->description }}
            </p>

            {{-- Contato e Info --}}
            <div class="flex flex-wrap items-center gap-2 sm:gap-3 text-xs text-gray-500 dark:text-gray-400">
                <div class="flex items-center gap-1">
                    <x-icon name="lucide.user" class="w-3 h-3 sm:w-3.5 sm:h-3.5" />
                    <span class="truncate max-w-30 sm:max-w-none">{{ $installment->transaction->contact->name }}</span>
                </div>
                <div class="flex items-center gap-1">
                    <x-icon name="lucide.calendar" class="w-3 h-3 sm:w-3.5 sm:h-3.5" />
                    <span>{{ \Carbon\Carbon::parse($installment->due_date)->format('d/m/Y') }}</span>
                </div>
                @if($installment->transaction->installments > 1)
                    <div class="flex items-center gap-1">
                        <x-icon name="lucide.layers" class="w-3 h-3 sm:w-3.5 sm:h-3.5" />
                        <span class="font-semibold">{{ $installment->installment }}/{{ $installment->transaction->installments }}</span>
                    </div>
                @endif
            </div>
        </div>

        {{-- Valor e Ações --}}
        <div class="flex flex-col items-end gap-1.5 sm:gap-2">
            <div class="{{ $textColor }} font-bold text-sm sm:text-lg whitespace-nowrap">
                {{ $isIncome ? '+' : '-' }} R$ {{ number_format($installment->amount, 2, ',', '.') }}
            </div>

            <div class="flex items-center gap-0.5 sm:gap-1">
                <x-button
                    class="btn-xs btn-ghost text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 hover:bg-blue-50 dark:hover:bg-blue-900/30"
                    link="{{ route('transactions.edit', $installment->transaction->id) }}"
                    icon="lucide.pencil"
                    tooltip="Editar"
                />

                <x-button
                    class="btn-xs btn-ghost text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-900/30"
                    wire:click="$dispatch('transactions::destroy', { id: {{ $installment->transaction->id }} })"
                    icon="lucide.trash"
                    spinner
                    tooltip="Excluir"
                />
            </div>
        </div>
    </div>
</div>
