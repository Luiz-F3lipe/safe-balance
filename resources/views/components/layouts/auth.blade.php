<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title.' - '.config('app.name') : config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen font-sans antialiased bg-linear-to-br from-emerald-50 via-teal-50 to-cyan-50 dark:from-gray-900 dark:via-emerald-950 dark:to-gray-900">

    {{-- Decorative Elements --}}
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-0 left-0 w-64 h-64 bg-emerald-200/30 dark:bg-emerald-500/10 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-teal-200/30 dark:bg-teal-500/10 rounded-full blur-3xl translate-x-1/2 translate-y-1/2"></div>
        <div class="absolute top-1/2 right-1/4 w-72 h-72 bg-cyan-200/20 dark:bg-cyan-500/5 rounded-full blur-3xl"></div>
    </div>

    {{-- Theme Toggle - Positioned top right --}}
    <div class="fixed top-4 right-4 z-50 sm:top-6 sm:right-6">
        <x-theme-toggle
            class="btn btn-circle btn-ghost btn-sm hover:bg-white/80 dark:hover:bg-gray-800/80 shadow-lg backdrop-blur-sm"
        />
    </div>

    {{-- Logo/Brand - Positioned top left --}}
    <div class="fixed top-4 left-4 z-40 sm:top-6 sm:left-6">
        <a href="/" class="flex items-center gap-2 text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 transition-colors">
            <div class="w-8 h-8 sm:w-10 sm:h-10 bg-linear-to-br from-emerald-500 to-teal-600 rounded-lg flex items-center justify-center shadow-lg">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <span class="font-bold text-lg sm:text-xl hidden sm:inline">SafeBalance</span>
        </a>
    </div>

    {{-- Main Content --}}
    <div class="relative flex items-center justify-center min-h-screen p-4 sm:p-6">
        <div class="w-full max-w-md">
            {{ $slot }}
        </div>
    </div>

    {{-- TOAST area --}}
    <x-toast />
</body>
</html>
