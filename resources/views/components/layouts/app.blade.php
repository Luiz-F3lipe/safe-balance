<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' - ' . config('app.name') : config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen font-sans antialiased bg-base-200 mx-0! px-0!">

    {{-- NAVBAR mobile only --}}
    <x-nav sticky class="lg:hidden">
        <x-slot:brand>
            <x-app-logo />
        </x-slot:brand>
        <x-slot:actions>
            <label for="main-drawer" class="lg:hidden me-3">
                <x-icon name="o-bars-3" class="cursor-pointer" />
            </label>
        </x-slot:actions>
    </x-nav>

    {{-- MAIN --}}
    <x-main>
        {{-- SIDEBAR --}}
        <x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-100 lg:bg-inherit relative px-0! mx-0!">

            {{-- BRAND --}}
            <x-app-logo class="px-5 pt-4" />

            {{-- MENU --}}
            <x-menu activate-by-route>

                {{-- User --}}
                @if ($user = auth()->user())
                    <div class="text-lg text-emerald-500 font-bold ml-1 mt-4 flex justify-center">
                        {{ $user->account?->name ?? 'Sem conta' }}
                    </div>

                    <x-menu-separator />
                    <x-list-item :item="$user" value="name" sub-value="email" no-separator no-hover
                        class="-mx-2 -my-2! rounded">
                        <x-slot:actions>
                            <x-button icon="o-power"
                                class="btn-circle btn-ghost btn-xs hover:bg-red-500/10 text-red-600 hover:text-red-800"
                                tooltip-left="Sair" no-wire-navigate link="/logout" />
                        </x-slot:actions>
                    </x-list-item>

                    <x-menu-separator />
                @endif

                <x-menu-item title="Dashboard" icon="lucide.chart-column-big" class="hover:bg-linear-to-br hover:from-emerald-500 hover:to-emerald-600 hover:text-white dark:hover:from-emerald-600 dark:hover:to-emerald-700 transition-all" />
                <x-menu-item title="Transações" icon="lucide.dollar-sign" link="/transactions" class="hover:bg-linear-to-br hover:from-emerald-500 hover:to-emerald-600 hover:text-white dark:hover:from-emerald-600 dark:hover:to-emerald-700 transition-all" />
                <x-menu-item title="Contatos" icon="lucide.contact" link="/contacts" class="hover:bg-linear-to-br hover:from-emerald-500 hover:to-emerald-600 hover:text-white dark:hover:from-emerald-600 dark:hover:to-emerald-700 transition-all" />
                <x-menu-item title="Categorias" icon="lucide.tag" link="/categories" class="hover:bg-linear-to-br hover:from-emerald-500 hover:to-emerald-600 hover:text-white dark:hover:from-emerald-600 dark:hover:to-emerald-700 transition-all" />
                <x-menu-item title="Usuários" icon="lucide.users" link="/users" class="hover:bg-linear-to-br hover:from-emerald-500 hover:to-emerald-600 hover:text-white dark:hover:from-emerald-600 dark:hover:to-emerald-700 transition-all" />
            </x-menu>

            {{-- THEME TOGGLE - Fixed at bottom --}}
            <div class="absolute bottom-12 left-0 right-0 px-5">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Tema</span>
                    <x-theme-toggle class="btn btn-sm btn-ghost hover:bg-base-300" />
                </div>
                <x-menu-separator class="mb-3" />
            </div>
        </x-slot:sidebar>

        {{-- The `$slot` goes here --}}
        <x-slot:content>
            {{ $slot }}
        </x-slot:content>
    </x-main>

    {{--  TOAST area --}}
    <x-toast />
</body>

</html>
