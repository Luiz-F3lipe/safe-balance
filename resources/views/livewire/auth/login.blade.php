<div>
    {{-- Login Card --}}
    <x-card class="backdrop-blur-sm bg-white/90 dark:bg-gray-800/90 shadow-2xl border-0">
        {{-- Header --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-linear-to-br from-emerald-500 to-teal-600 rounded-2xl mb-4 shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-2">
                Bem-vindo de volta!
            </h1>
            <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">
                Entre com suas credenciais para continuar
            </p>
        </div>

        {{-- Form --}}
        <x-form wire:submit="login" class="space-y-4">
            {{-- Email Input --}}
            <x-input
                label="E-mail"
                wire:model="email"
                icon="o-envelope"
                placeholder="seu@email.com"
                type="email"
                inline
            />

            {{-- Password Input --}}
            <x-input
                label="Senha"
                wire:model="password"
                type="password"
                icon="o-lock-closed"
                placeholder="••••••••"
                inline
            />

            {{-- Remember Me & Forgot Password --}}
            <div class="flex items-center justify-between mb-6">
                <x-checkbox
                    label="Lembrar-me"
                    wire:model="remember"
                    class="text-sm"
                />
                <a href="/forgot-password" class="text-sm font-medium text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 dark:hover:text-emerald-300 transition-colors">
                    Esqueceu a senha?
                </a>
            </div>

            {{-- Submit Button --}}
            <x-slot:actions>
                <div class="w-full space-y-4">
                    <x-button
                        label="Entrar"
                        type="submit"
                        icon="o-arrow-right-on-rectangle"
                        class="btn-primary bg-linear-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 border-0 w-full shadow-lg hover:shadow-xl transition-all"
                        spinner="login"
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

                    {{-- Register Link --}}
                    <div class="text-center">
                        <span class="text-sm text-gray-600 dark:text-gray-400">
                            Não tem uma conta?
                        </span>
                        <a href="/register" wire:navigate class="text-sm font-semibold text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 dark:hover:text-emerald-300 ml-1 transition-colors">
                            Criar conta
                        </a>
                    </div>
                </div>
            </x-slot:actions>
        </x-form>
    </x-card>

    {{-- Security Notice --}}
    <div class="mt-6 text-center">
        <p class="text-xs text-gray-500 dark:text-gray-400 flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
            Sua conexão é segura e criptografada
        </p>
    </div>
</div>
