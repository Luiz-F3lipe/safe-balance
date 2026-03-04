<div class="w-full max-w-7xl mx-auto" x-data="{ categoryOpen: @entangle('categoryDropdownOpen'), contactOpen: @entangle('contactDropdownOpen') }">
    <div
        class="bg-white dark:bg-gray-800 rounded-lg sm:rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 sm:p-6">
        <div class="space-y-4 sm:space-y-5">
            {{-- Categoria --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl p-4 sm:p-5 shadow-md border-2 border-emerald-200 dark:border-emerald-800" @click.away="categoryOpen = false">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-full bg-linear-to-br from-emerald-500 to-teal-600 text-white flex items-center justify-center shadow-lg">
                        <x-icon name="lucide.tag" class="w-5 h-5" />
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white text-sm">Categoria</h3>
                        <p class="text-xs text-gray-600 dark:text-gray-400">Selecione ou crie uma nova</p>
                    </div>
                </div>

                {{-- Selected Category Card --}}
                @if($this->selectedCategory)
                    <div class="mb-3">
                        <div class="bg-linear-to-r from-gray-50 to-white dark:from-gray-900 dark:to-gray-800 rounded-lg p-3 border border-gray-200 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    @if($this->selectedCategory->type === 'income')
                                        <div class="w-10 h-10 rounded-full bg-linear-to-br from-emerald-400 to-teal-500 flex items-center justify-center shadow-md">
                                            <x-icon name="lucide.trending-up" class="w-5 h-5 text-white" />
                                        </div>
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-linear-to-br from-red-400 to-rose-500 flex items-center justify-center shadow-md">
                                            <x-icon name="lucide.trending-down" class="w-5 h-5 text-white" />
                                        </div>
                                    @endif
                                    <div>
                                        <div class="font-semibold text-gray-900 dark:text-white">{{ $this->selectedCategory->description }}</div>
                                        <div class="text-xs">
                                            @if($this->selectedCategory->type === 'income')
                                                <span class="text-emerald-600 dark:text-emerald-400 font-medium">Receita</span>
                                            @else
                                                <span class="text-red-600 dark:text-red-400 font-medium">Despesa</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <button wire:click="clearCategory" class="text-gray-400 hover:text-red-500 transition-colors" type="button">
                                    <x-icon name="lucide.x" class="w-5 h-5" />
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Input with Button --}}
                <div class="flex gap-2">
                    <div class="flex-1 relative">
                        <div class="relative">
                            <input
                                type="text"
                                wire:model.live="categorySearch"
                                wire:focus="categoryDropdownOpen = true"
                                placeholder="{{ $this->selectedCategory ? 'Alterar categoria...' : 'Buscar categoria...' }}"
                                class="input input-bordered w-full pl-10 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                            />
                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                <x-icon name="lucide.search" class="w-4 h-4" />
                            </div>
                        </div>

                        {{-- Dropdown --}}
                        @if($categoryDropdownOpen && $this->filteredCategories->isNotEmpty())
                            <div class="absolute z-50 w-full mt-2 bg-white dark:bg-gray-800 rounded-lg shadow-xl border border-gray-200 dark:border-gray-700 max-h-64 overflow-y-auto">
                                @foreach($this->filteredCategories as $category)
                                    <button
                                        type="button"
                                        wire:click="selectCategory({{ $category->id }})"
                                        class="w-full px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 flex items-center gap-3 border-b border-gray-100 dark:border-gray-700 last:border-0 transition-colors"
                                    >
                                        @if($category->type === 'income')
                                            <div class="w-8 h-8 rounded-full bg-linear-to-br from-emerald-400 to-teal-500 flex items-center justify-center shrink-0">
                                                <x-icon name="lucide.trending-up" class="w-4 h-4 text-white" />
                                            </div>
                                        @else
                                            <div class="w-8 h-8 rounded-full bg-linear-to-br from-red-400 to-rose-500 flex items-center justify-center shrink-0">
                                                <x-icon name="lucide.trending-down" class="w-4 h-4 text-white" />
                                            </div>
                                        @endif
                                        <div class="text-left flex-1">
                                            <div class="font-medium text-gray-900 dark:text-white">{{ $category->description }}</div>
                                            <div class="text-xs">
                                                @if($category->type === 'income')
                                                    <span class="text-emerald-600 dark:text-emerald-400">Receita</span>
                                                @else
                                                    <span class="text-red-600 dark:text-red-400">Despesa</span>
                                                @endif
                                            </div>
                                        </div>
                                    </button>
                                @endforeach
                            </div>
                        @endif

                        {{-- Empty State --}}
                        @if($categoryDropdownOpen && $this->filteredCategories->isEmpty())
                            <div class="absolute z-50 w-full mt-2 bg-white dark:bg-gray-800 rounded-lg shadow-xl border border-gray-200 dark:border-gray-700 p-4 text-center">
                                <div class="text-gray-500 dark:text-gray-400 text-sm">
                                    <x-icon name="lucide.search-x" class="w-8 h-8 mx-auto mb-2 text-gray-300" />
                                    Nenhuma categoria encontrada
                                </div>
                            </div>
                        @endif
                    </div>

                    <x-button
                        icon="lucide.plus"
                        class="btn-success text-white btn-circle btn-md shrink-0"
                        tooltip="Adicionar nova categoria"
                        wire:click="$dispatch('categories::create', { otherEvent: true })"
                        type="button"
                    />
                </div>

                @if($this->categories->isEmpty())
                    <div class="mt-2 text-xs text-amber-600 dark:text-amber-400">
                        Você precisa criar uma categoria primeiro
                    </div>
                @endif
            </div>

            {{-- Contato --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl p-4 sm:p-5 shadow-md border-2 border-blue-200 dark:border-blue-800" @click.away="contactOpen = false">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-full bg-linear-to-br from-blue-500 to-cyan-600 text-white flex items-center justify-center shadow-lg">
                        <x-icon name="lucide.user" class="w-5 h-5" />
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white text-sm">Contato</h3>
                        <p class="text-xs text-gray-600 dark:text-gray-400">Selecione ou crie um novo</p>
                    </div>
                </div>

                {{-- Selected Contact Card --}}
                @if($this->selectedContact)
                    <div class="mb-3">
                        <div class="bg-linear-to-r from-gray-50 to-white dark:from-gray-900 dark:to-gray-800 rounded-lg p-3 border border-gray-200 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-linear-to-br from-blue-400 to-cyan-500 flex items-center justify-center shadow-md">
                                        <x-icon name="lucide.user" class="w-5 h-5 text-white" />
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-900 dark:text-white">{{ $this->selectedContact->name }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 font-mono">#{{ $this->selectedContact->id }}</div>
                                    </div>
                                </div>
                                <button wire:click="clearContact" class="text-gray-400 hover:text-red-500 transition-colors" type="button">
                                    <x-icon name="lucide.x" class="w-5 h-5" />
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Input with Button --}}
                <div class="flex gap-2">
                    <div class="flex-1 relative">
                        <div class="relative">
                            <input
                                type="text"
                                wire:model.live="contactSearch"
                                wire:focus="contactDropdownOpen = true"
                                placeholder="{{ $this->selectedContact ? 'Alterar contato...' : 'Buscar contato...' }}"
                                class="input input-bordered w-full pl-10 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            />
                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                <x-icon name="lucide.search" class="w-4 h-4" />
                            </div>
                        </div>

                        {{-- Dropdown --}}
                        @if($contactDropdownOpen && $this->filteredContacts->isNotEmpty())
                            <div class="absolute z-50 w-full mt-2 bg-white dark:bg-gray-800 rounded-lg shadow-xl border border-gray-200 dark:border-gray-700 max-h-64 overflow-y-auto">
                                @foreach($this->filteredContacts as $contact)
                                    <button
                                        type="button"
                                        wire:click="selectContact({{ $contact->id }})"
                                        class="w-full px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 flex items-center gap-3 border-b border-gray-100 dark:border-gray-700 last:border-0 transition-colors"
                                    >
                                        <div class="w-8 h-8 rounded-full bg-linear-to-br from-blue-400 to-cyan-500 flex items-center justify-center shrink-0">
                                            <x-icon name="lucide.user" class="w-4 h-4 text-white" />
                                        </div>
                                        <div class="text-left flex-1">
                                            <div class="font-medium text-gray-900 dark:text-white">{{ $contact->name }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 font-mono">#{{ $contact->id }}</div>
                                        </div>
                                    </button>
                                @endforeach
                            </div>
                        @endif

                        {{-- Empty State --}}
                        @if($contactDropdownOpen && $this->filteredContacts->isEmpty())
                            <div class="absolute z-50 w-full mt-2 bg-white dark:bg-gray-800 rounded-lg shadow-xl border border-gray-200 dark:border-gray-700 p-4 text-center">
                                <div class="text-gray-500 dark:text-gray-400 text-sm">
                                    <x-icon name="lucide.search-x" class="w-8 h-8 mx-auto mb-2 text-gray-300" />
                                    Nenhum contato encontrado
                                </div>
                            </div>
                        @endif
                    </div>

                    <x-button
                        icon="lucide.plus"
                        class="btn-success text-white btn-circle btn-md shrink-0"
                        tooltip="Adicionar novo contato"
                        wire:click="$dispatch('contacts::create', { otherEvent: true })"
                        type="button"
                    />
                </div>

                @if($this->contacts->isEmpty())
                    <div class="mt-2 text-xs text-amber-600 dark:text-amber-400">
                        Você precisa criar um contato primeiro
                    </div>
                @endif
            </div>

            {{-- Descrição --}}
            <div>
                <x-input label="Descrição" wire:model="transaction.description" placeholder="Ex: Compra no supermercado"
                    icon="lucide.file-text" maxlength="100" class="w-full" />
            </div>

            {{-- Valor e Parcelas em Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                {{-- Valor --}}
                <div>
                    <x-input label="Valor Total" wire:model.live="transaction.amount" type="number" step="0.01"
                        min="0.01" placeholder="0,00" icon="lucide.dollar-sign" prefix="R$" class="w-full" />
                </div>

                {{-- Número de Parcelas --}}
                <div>
                    <x-input label="Parcelas" wire:model.live="installments" type="number" min="1"
                        max="360" placeholder="1" icon="lucide.calendar-range" class="w-full" />
                </div>
            </div>

            {{-- Preview do Valor da Parcela --}}
            @if ($transaction?->amount && $installments >= 1)
                <div
                    class="p-3 sm:p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-lg">
                    <div class="flex items-center gap-2 text-emerald-700 dark:text-emerald-300">
                        <x-icon name="lucide.info" class="w-4 h-4 sm:w-5 sm:h-5 shrink-0" />
                        <div class="text-xs sm:text-sm">
                            <span class="font-medium">Valor de cada parcela:</span>
                            <span class="font-bold ml-1">
                                R$ {{ number_format($this->installmentAmount, 2, ',', '.') }}
                            </span>
                            <span class="text-emerald-600 dark:text-emerald-400 ml-1">
                                ({{ $installments }}x)
                            </span>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Data do Primeiro Vencimento --}}
            <div>
                <x-input label="Data do Primeiro Vencimento" wire:model.live="firstDueDate" type="date"
                    icon="lucide.calendar" class="w-full"
                    hint="As próximas parcelas serão geradas mensalmente a partir desta data" />
            </div>

            {{-- Preview das Parcelas (quando houver mais de 1) --}}
            @if ($installments > 1 && $firstDueDate && $transaction?->amount)
                <div class="space-y-2">
                    <div
                        class="flex items-center gap-2 text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300">
                        <x-icon name="lucide.list" class="w-4 h-4" />
                        <span>Preview das Parcelas:</span>
                    </div>

                    <div
                        class="max-h-48 overflow-y-auto space-y-1.5 p-2 sm:p-3 bg-gray-50 dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
                        @php
                            $installmentAmount = $this->installmentAmount;
                            $remainder = $transaction->amount - $installmentAmount * $installments;
                            $dueDate = \Carbon\Carbon::parse($firstDueDate);
                        @endphp

                        @for ($i = 1; $i <= min($installments, 12); $i++)
                            @php
                                $value =
                                    $i === $installments && $remainder != 0
                                        ? $installmentAmount + $remainder
                                        : $installmentAmount;
                                $date = $dueDate->copy()->addMonths($i - 1);
                            @endphp

                            <div
                                class="flex items-center justify-between text-xs sm:text-sm p-2 bg-white dark:bg-gray-800 rounded border border-gray-100 dark:border-gray-700">
                                <span class="text-gray-600 dark:text-gray-400 font-medium">
                                    Parcela {{ $i }}/{{ $installments }}
                                </span>
                                <span class="text-gray-900 dark:text-gray-100 font-semibold">
                                    R$ {{ number_format($value, 2, ',', '.') }}
                                </span>
                                <span class="text-gray-500 dark:text-gray-500 text-xs">
                                    {{ $date->format('d/m/Y') }}
                                </span>
                            </div>
                        @endfor

                        @if ($installments > 12)
                            <div class="text-center text-xs text-gray-500 dark:text-gray-400 py-2">
                                ... e mais {{ $installments - 12 }} parcelas
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        {{-- Action Buttons --}}
        <div class="flex flex-col sm:flex-row gap-3 mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
            <x-button label="Cancelar" wire:click="cancel" class="btn-ghost w-full sm:w-auto" icon="lucide.x" />
            <x-button wire:click="save" label="Salvar Transação"
                class="btn-success text-white w-full sm:w-auto sm:ml-auto" spinner="save" icon="lucide.check" />
        </div>
    </div>
</div>
