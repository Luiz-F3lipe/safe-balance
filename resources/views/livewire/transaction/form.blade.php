<div class="max-w-3xl">
    <div class="bg-white dark:bg-gray-800 rounded-lg sm:rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 sm:p-6">
        <div class="space-y-4 sm:space-y-5">
            {{-- Categoria --}}
            <div>
                <x-select
                    label="Categoria"
                    wire:model.live="transaction.category_id"
                    :options="$this->categories"
                    option-value="id"
                    option-label="description"
                    placeholder="Selecione a categoria"
                    icon="lucide.tag"
                    class="w-full"
                    :hint="$this->categories->isEmpty() ? 'Você precisa criar uma categoria primeiro' : ''"
                />
            </div>

            {{-- Contato (Opcional) --}}
            <div>
                <x-select
                    label="Contato"
                    wire:model.live="transaction.contact_id"
                    :options="$this->contacts"
                    option-value="id"
                    option-label="name"
                    placeholder="Selecione o contato"
                    icon="lucide.user"
                    class="w-full"
                />
            </div>

            {{-- Descrição --}}
            <div>
                <x-input
                    label="Descrição"
                    wire:model="transaction.description"
                    placeholder="Ex: Compra no supermercado"
                    icon="lucide.file-text"
                    maxlength="100"
                    class="w-full"
                />
            </div>

            {{-- Valor e Parcelas em Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                {{-- Valor --}}
                <div>
                    <x-input
                        label="Valor Total"
                        wire:model.live="transaction.amount"
                        type="number"
                        step="0.01"
                        min="0.01"
                        placeholder="0,00"
                        icon="lucide.dollar-sign"
                        prefix="R$"
                        class="w-full"
                    />
                </div>

                {{-- Número de Parcelas --}}
                <div>
                    <x-input
                        label="Parcelas"
                        wire:model.live="installments"
                        type="number"
                        min="1"
                        max="360"
                        placeholder="1"
                        icon="lucide.calendar-range"
                        class="w-full"
                    />
                </div>
            </div>

            {{-- Preview do Valor da Parcela --}}
            @if($transaction?->amount && $installments >= 1)
                <div class="p-3 sm:p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-lg">
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
                <x-input
                    label="Data do Primeiro Vencimento"
                    wire:model.live="firstDueDate"
                    type="date"
                    icon="lucide.calendar"
                    class="w-full"
                    hint="As próximas parcelas serão geradas mensalmente a partir desta data"
                />
            </div>

            {{-- Preview das Parcelas (quando houver mais de 1) --}}
            @if($installments > 1 && $firstDueDate && $transaction?->amount)
                <div class="space-y-2">
                    <div class="flex items-center gap-2 text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300">
                        <x-icon name="lucide.list" class="w-4 h-4" />
                        <span>Preview das Parcelas:</span>
                    </div>

                    <div class="max-h-48 overflow-y-auto space-y-1.5 p-2 sm:p-3 bg-gray-50 dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
                        @php
                            $installmentAmount = $this->installmentAmount;
                            $remainder = $transaction->amount - ($installmentAmount * $installments);
                            $dueDate = \Carbon\Carbon::parse($firstDueDate);
                        @endphp

                        @for($i = 1; $i <= min($installments, 12); $i++)
                            @php
                                $value = ($i === $installments && $remainder != 0)
                                    ? $installmentAmount + $remainder
                                    : $installmentAmount;
                                $date = $dueDate->copy()->addMonths($i - 1);
                            @endphp

                            <div class="flex items-center justify-between text-xs sm:text-sm p-2 bg-white dark:bg-gray-800 rounded border border-gray-100 dark:border-gray-700">
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

                        @if($installments > 12)
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
            <x-button
                label="Cancelar"
                wire:click="cancel"
                class="btn-ghost w-full sm:w-auto"
                icon="lucide.x"
            />
            <x-button
                wire:click="save"
                label="Salvar Transação"
                class="btn-success text-white w-full sm:w-auto sm:ml-auto"
                spinner="save"
                icon="lucide.check"
            />
        </div>
    </div>
</div>
