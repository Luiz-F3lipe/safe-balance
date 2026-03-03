<div>
    {{-- Register Card --}}
    <x-card class="backdrop-blur-sm bg-white/90 dark:bg-gray-800/90 shadow-2xl border-0">
        {{-- Header --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-linear-to-br from-emerald-500 to-teal-600 rounded-2xl mb-4 shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-2">
                Criar nova conta
            </h1>
            <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">
                Comece a gerenciar suas finanças hoje
            </p>
        </div>

        {{-- Form --}}
        <x-form wire:submit="handle" class="space-y-3">
            {{-- Account Name Input --}}
            <x-input
                label="Nome da conta"
                wire:model="account.name"
                icon="lucide.credit-card"
                placeholder="Conta Pessoal"
                inline
                hint="Nome da conta que você deseja criar"
            />

            {{-- User Name Input --}}
            <x-input
                label="Seu nome"
                wire:model="user.name"
                icon="o-user"
                placeholder="João Silva"
                inline
                hint="Seu nome completo"
            />

            {{-- Email Input --}}
            <x-input
                label="E-mail"
                wire:model="user.email"
                icon="o-envelope"
                placeholder="seu@email.com"
                type="email"
                inline
                hint="Email que será seu usuário de acesso"
            />

            {{-- Password Input --}}
            <x-input
                label="Senha"
                wire:model="password"
                type="password"
                icon="o-lock-closed"
                placeholder="••••••••"
                hint="Mínimo de 4 caracteres"
                inline
            />

            {{-- Password Confirmation Input --}}
            <x-input
                label="Confirmar senha"
                wire:model="password_confirmation"
                type="password"
                icon="o-lock-closed"
                placeholder="••••••••"
                inline
            />

            {{-- Terms & Conditions --}}
            <div class="mb-3">
                <x-checkbox wire:model="terms">
                    <x-slot:label>
                        <span class="text-sm text-gray-600 dark:text-gray-400">
                            Eu concordo com os
                            <a href="/terms" class="font-medium text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 dark:hover:text-emerald-300 transition-colors">
                                Termos de Uso
                            </a>
                            e
                            <a href="/privacy" class="font-medium text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 dark:hover:text-emerald-300 transition-colors">
                                Política de Privacidade
                            </a>
                        </span>
                    </x-slot:label>
                </x-checkbox>
            </div>

            {{-- Submit Button --}}
            <x-slot:actions>
                <div class="w-full space-y-4">
                    <x-button
                        label="Criar conta"
                        type="submit"
                        icon="o-user-plus"
                        class="btn-primary bg-linear-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 border-0 w-full shadow-lg hover:shadow-xl transition-all"
                        spinner="handle"
                    />

                    {{-- Divider --}}
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400">
                                ou
                            </span>
                        </div>
                    </div>

                    {{-- Login Link --}}
                    <div class="text-center">
                        <span class="text-sm text-gray-600 dark:text-gray-400">
                            Já tem uma conta?
                        </span>
                        <a href="/login" wire:navigate class="text-sm font-semibold text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 dark:hover:text-emerald-300 ml-1 transition-colors">
                            Fazer login
                        </a>
                    </div>
                </div>
            </x-slot:actions>
        </x-form>
    </x-card>

    {{-- Benefits Section --}}
    <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="text-center p-3 rounded-lg bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm">
            <div class="text-emerald-600 dark:text-emerald-400 mb-1">
                <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </div>
            <p class="text-xs font-medium text-gray-700 dark:text-gray-300">100% Seguro</p>
        </div>
        <div class="text-center p-3 rounded-lg bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm">
            <div class="text-emerald-600 dark:text-emerald-400 mb-1">
                <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <p class="text-xs font-medium text-gray-700 dark:text-gray-300">Rápido</p>
        </div>
        <div class="text-center p-3 rounded-lg bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm">
            <div class="text-emerald-600 dark:text-emerald-400 mb-1">
                <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                </svg>
            </div>
            <p class="text-xs font-medium text-gray-700 dark:text-gray-300">Grátis</p>
        </div>
    </div>
</div>
