<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="light">

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

<body class="min-h-screen bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r flex flex-col">
            <div class="h-16 flex items-center px-6 border-b">
                <x-flux::heading size="lg">
                    ERP
                </x-flux::heading>
            </div>

            <nav class="flex-1 px-3 py-4 space-y-1">
                @foreach (config('core.navigation') as $item )
                <x-flux::button variant="ghost" class="w-full justify-start cursor-pointer" :href="route($item['route'])">
                    {{ $item['label'] }}
                </x-flux::button>
                @endforeach
            </nav>
        </aside>


        <!-- Main area -->
        <div class="flex-1 flex flex-col">
            <!-- Top bar -->
            <header class="h-16 bg-white border-b flex items-center justify-between px-6">
                <div>
                    <x-flux::heading size="sm">
                        Dashboard
                    </x-flux::heading>
                </div>

                <livewire:core.top-bar.user-menu />
            </header>

            <!-- Page content -->
            <main class="flex-1 overflow-y-auto p-6">
                {{ $slot }}
            </main>
        </div>
    </div>
    @fluxScripts
</body>

</html>