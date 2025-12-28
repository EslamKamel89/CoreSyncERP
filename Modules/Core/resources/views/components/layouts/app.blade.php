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
                @if (isset($item['children']))
                @php
                $hasActiveChild = collect($item['children'])
                ->pluck('route')
                ->contains(fn($route)=>request()->routeIs($route));
                @endphp
                <div x-data="{open:{{ $hasActiveChild ? 'true' : 'false' }} }" class="space-y-1">
                    <button
                        @click="open = !open"
                        type="button"
                        class="px-3 text-xs font-semibold text-gray-500 uppercase cursor-pointer flex flex-row justify-between w-full">
                        <span>{{ __($item['label']) }}</span>
                        <div x-bind:class="{ 'transition-transform':true , '-rotate-180': open }">
                            <flux:icon.chevron-down class="h-4 w-4" />
                        </div>
                    </button>
                    <div class="space-y-1 pl-2" x-show="open" x-collapse>
                        @foreach ($item['children'] as $child)
                        @if (!isset($child['permission']) || auth()->user()?->can($child['permission']))
                        @php
                        $isActive = request()->routeIs($child['route']);
                        @endphp
                        <x-flux::button
                            variant="{{ $isActive ? 'primary' : 'ghost' }}"
                            size="sm"
                            class="w-full justify-start cursor-pointer"
                            :href="route($child['route'])">
                            {{ __($child['label']) }}
                        </x-flux::button>
                        @endif
                        @endforeach
                    </div>
                </div>
                @else
                @php
                $isActive = request()->routeIs($item['route'])
                @endphp
                <x-flux::button
                    variant="{{ $isActive ? 'primary' : 'ghost' }}"
                    size="sm"
                    class="w-full justify-start cursor-pointer" :href="route($item['route'])">
                    {{ __($item['label']) }}
                </x-flux::button>
                @endif
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
    <x-toaster-hub />
    @fluxScripts
</body>

</html>