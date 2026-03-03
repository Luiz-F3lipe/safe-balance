<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title.' - '.config('app.name') : config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen font-sans antialiased bg-linear-to-br from-blue-50 via-indigo-50 to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">

    {{-- Theme Toggle - Positioned top right --}}
    <div class="absolute top-6 right-6 z-50">
        <x-theme-toggle
            class="btn btn-circle btn-ghost btn-sm hover:bg-white/50 dark:hover:bg-gray-800/50"
        />
    </div>

    {{-- Main Content --}}
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="w-full max-w-md">
            {{ $slot }}
        </div>
    </div>

    {{-- TOAST area --}}
    <x-toast />
</body>
</html>
