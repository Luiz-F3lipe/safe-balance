<div class="p-4 sm:p-6">
    {{-- Cartão de Resumo da Conta --}}
    <div class="mb-6">
        <x-transaction.account-card
            :account-name="$this->currentAccount?->name"
            :total-income="$this->totalIncome"
            :total-expense="$this->totalExpense"
            :balance="$this->balance"
            :show-balance="$showBalance"
        />
    </div>

    {{-- Botão Nova Transação --}}
    <div class="mb-4">
        <x-button
            icon="o-plus"
            class="btn-success w-full text-white shadow-md hover:shadow-lg transition-shadow"
            wire:click="$dispatch('transactions::create')"
        >
            Nova Transação
        </x-button>
    </div>

    {{-- Filtros --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-4">
        <div class="col-span-1">
            <x-select
                wire:model.live="selectedMonth"
                :options="$monthOptions"
                option-value="id"
                option-label="name"
                placeholder="Selecione o mês"
                class="w-full"
                icon="lucide.calendar"
            />
        </div>

        <div class="col-span-1">
            <x-input
                wire:model.live.debounce="search"
                icon="o-magnifying-glass"
                placeholder="Buscar transação"
                class="w-full"
            />
        </div>
    </div>

    {{-- Cards de Transações --}}
    <div class="space-y-2 sm:space-y-3 mb-6">
        @forelse ($this->transactions as $installment)
            <x-transaction.installment-card :installment="$installment" />
        @empty
            <div class="flex flex-col items-center gap-3 sm:gap-4 py-12 sm:py-16 bg-gray-50 dark:bg-gray-800/50 rounded-lg sm:rounded-xl border-2 border-dashed border-gray-200 dark:border-gray-700">
                <div class="w-12 h-12 sm:w-16 sm:h-16 rounded-full bg-emerald-100 dark:bg-emerald-900/50 text-emerald-500 dark:text-emerald-400 flex items-center justify-center">
                    <x-icon name="lucide.wallet" class="w-6 h-6 sm:w-8 sm:h-8" />
                </div>
                <div class="text-center px-4">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-gray-100 mb-1 sm:mb-2">Nenhuma transação encontrada</h3>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mb-3 sm:mb-4">
                        @if ($search)
                            Nenhuma transação corresponde à busca por "{{ $search }}"
                        @else
                            Comece criando sua primeira transação
                        @endif
                    </p>

                    @if ($search || $selectedMonth != now()->month)
                        <x-button
                            wire:click="cleanerFilter"
                            class="btn-outline btn-sm btn-success"
                            icon="lucide.filter-x"
                        >
                            Limpar Filtros
                        </x-button>
                    @endif
                </div>
            </div>
        @endforelse
    </div>

    {{-- Modais (quando criar os componentes) --}}
    {{-- <livewire:transaction.create :key="uniqid()" /> --}}
    {{-- <livewire:transaction.edit :key="uniqid()" /> --}}
    {{-- <livewire:transaction.destroy :key="uniqid()" /> --}}
</div>
