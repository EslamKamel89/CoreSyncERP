<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="light" dir="{{ $textDirection }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>{{ $title ?? config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="min-h-screen bg-gray-100 dark:bg-zinc-800 antialiased">
    <flux:sidebar
        sticky
        collapsible
        class="bg-zinc-50 dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-700">
        {{-- Sidebar header --}}
        <flux:sidebar.header>
            <flux:sidebar.brand
                href="#"
                name="ERP" />

            <flux:sidebar.collapse />
        </flux:sidebar.header>

        {{-- Sidebar navigation --}}
        <flux:sidebar.nav>
            @foreach (config('core.navigation') as $item)
            @if (isset($item['children']))
            <flux:sidebar.group
                expandable
                icon="{{ $item['icon'] ?? null }}"
                heading="{{ __($item['label']) }}">
                @foreach ($item['children'] as $child)
                @if (!isset($child['permission']) || auth()->user()?->can($child['permission']))
                <flux:sidebar.item
                    href="{{ route($child['route']) }}"
                    :current="request()->routeIs($child['route'])"
                    wire:navigate>
                    {{ __($child['label']) }}
                </flux:sidebar.item>
                @endif
                @endforeach
            </flux:sidebar.group>
            @else
            <flux:sidebar.item
                icon="{{ $item['icon'] ?? null }}"
                href="{{ route($item['route']) }}"
                :current="request()->routeIs($item['route'])"
                wire:navigate>
                {{ __($item['label']) }}
            </flux:sidebar.item>
            @endif
            @endforeach
        </flux:sidebar.nav>

        <flux:sidebar.spacer />


    </flux:sidebar>

    {{-- Mobile header --}}
    <flux:header>
        <flux:sidebar.toggle icon="bars-3" inset="left" />

        <flux:spacer />

        <livewire:core.top-bar.user-menu />
    </flux:header>

    {{-- Main content --}}
    <flux:main class="p-6">
        {{ $slot }}
    </flux:main>

    <x-toaster-hub />
    @fluxScripts
</body>

</html>