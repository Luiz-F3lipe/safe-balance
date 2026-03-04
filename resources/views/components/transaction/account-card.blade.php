@props(['accountName', 'totalIncome', 'totalExpense', 'balance', 'showBalance'])

<div>
    {{-- Nome da Conta com Botão de Mostrar/Ocultar Saldo --}}
    <div class="mb-3 flex items-center justify-between">
        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100">
                {{ $accountName ?? 'Minha Conta' }}
            </h2>
            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Resumo financeiro</p>
        </div>
        <button
            wire:click="toggleBalance"
            class="flex items-center gap-2 px-3 py-2 rounded-lg bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 transition-colors text-sm font-medium"
            title="{{ $showBalance ? 'Ocultar saldo' : 'Mostrar saldo' }}"
        >
            <x-icon name="{{ $showBalance ? 'lucide.eye-off' : 'lucide.eye' }}" class="w-4 h-4" />
            <span class="hidden sm:inline">{{ $showBalance ? 'Ocultar' : 'Mostrar' }}</span>
        </button>
    </div>

    {{-- Cards de Indicadores --}}
    <div class="grid grid-cols-1 sm:grid-cols-{{ $showBalance ? '3' : '2' }} gap-3 sm:gap-4">
        {{-- Card de Receitas --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between mb-3">
                <div class="flex items-center gap-2">
                    <div class="w-10 h-10 rounded-lg bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center">
                        <x-icon name="lucide.trending-up" class="w-5 h-5 text-emerald-600 dark:text-emerald-400" />
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Receitas</p>
                    </div>
                </div>
            </div>
            <div class="mt-2">
                <div
                    class="text-2xl font-bold text-emerald-600 dark:text-emerald-400"
                    x-data="{
                        displayIncome: 0,
                        targetIncome: {{ $totalIncome }},
                        animateIncome() {
                            let start = 0;
                            let duration = 1000;
                            let startTime = Date.now();
                            const animate = () => {
                                let elapsed = Date.now() - startTime;
                                let progress = Math.min(elapsed / duration, 1);
                                this.displayIncome = start + (this.targetIncome - start) * progress;
                                if (progress < 1) {
                                    requestAnimationFrame(animate);
                                } else {
                                    this.displayIncome = this.targetIncome;
                                }
                            };
                            animate();
                        }
                    }"
                    x-init="animateIncome()"
                >
                    R$ <span x-text="displayIncome.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })"></span>
                </div>
            </div>
        </div>

        {{-- Card de Despesas --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between mb-3">
                <div class="flex items-center gap-2">
                    <div class="w-10 h-10 rounded-lg bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                        <x-icon name="lucide.trending-down" class="w-5 h-5 text-red-600 dark:text-red-400" />
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Despesas</p>
                    </div>
                </div>
            </div>
            <div class="mt-2">
                <div
                    class="text-2xl font-bold text-red-600 dark:text-red-400"
                    x-data="{
                        displayExpense: 0,
                        targetExpense: {{ $totalExpense }},
                        animateExpense() {
                            let start = 0;
                            let duration = 1000;
                            let startTime = Date.now();
                            const animate = () => {
                                let elapsed = Date.now() - startTime;
                                let progress = Math.min(elapsed / duration, 1);
                                this.displayExpense = start + (this.targetExpense - start) * progress;
                                if (progress < 1) {
                                    requestAnimationFrame(animate);
                                } else {
                                    this.displayExpense = this.targetExpense;
                                }
                            };
                            animate();
                        }
                    }"
                    x-init="animateExpense()"
                >
                    R$ <span x-text="displayExpense.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })"></span>
                </div>
            </div>
        </div>

        {{-- Card de Saldo --}}
        @if($showBalance)
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex items-center gap-2">
                        <div class="w-10 h-10 rounded-lg {{ $balance >= 0 ? 'bg-blue-100 dark:bg-blue-900/30' : 'bg-orange-100 dark:bg-orange-900/30' }} flex items-center justify-center">
                            <x-icon name="lucide.wallet" class="w-5 h-5 {{ $balance >= 0 ? 'text-blue-600 dark:text-blue-400' : 'text-orange-600 dark:text-orange-400' }}" />
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Saldo</p>
                        </div>
                    </div>
                </div>
                <div class="mt-2">
                    <div
                        class="text-2xl font-bold {{ $balance >= 0 ? 'text-blue-600 dark:text-blue-400' : 'text-orange-600 dark:text-orange-400' }}"
                        x-data="{
                            displayBalance: 0,
                            targetBalance: {{ $balance }},
                            animateBalance() {
                                let start = 0;
                                let duration = 1000;
                                let startTime = Date.now();
                                const animate = () => {
                                    let elapsed = Date.now() - startTime;
                                    let progress = Math.min(elapsed / duration, 1);
                                    this.displayBalance = start + (this.targetBalance - start) * progress;
                                    if (progress < 1) {
                                        requestAnimationFrame(animate);
                                    } else {
                                        this.displayBalance = this.targetBalance;
                                    }
                                };
                                animate();
                            }
                        }"
                        x-init="animateBalance()"
                    >
                        R$ <span x-text="displayBalance.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })"></span>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
