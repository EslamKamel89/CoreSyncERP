@props([
'data',
])
@php
$headers = $data['headers'] ?? [];
$rows = $data['rows'] ?? [];
$emptyLabel = $data['emptyLabel'] ?? null;
@endphp

{{-- Desktop table --}}
<div class="hidden md:block overflow-x-auto">
    <table class="min-w-full border rounded-lg">
        <thead class="bg-gray-50">
            <tr>
                @foreach ($headers as $header)
                <th class="px-4 py-3 text-start text-sm font-medium text-gray-600">
                    {{ __($header) }}
                </th>
                @endforeach
                @if (!empty($rows) && !empty($rows[0]['actions']))
                <th class="px-4 py-3 flex justify-end text-sm font-medium text-gray-600">
                    <flux:icon.wrench-screwdriver />
                </th>
                @endif
            </tr>
        </thead>

        <tbody class="divide-y">
            @forelse ($rows as $row)
            <tr>
                @foreach ($row['cells'] as $cell)
                <td class="px-4 py-3 font-medium">
                    {{ $cell}}
                </td>
                @endforeach
                @if (!empty($row['actions']))
                <td class="px-4 py-3 flex justify-end">
                    @foreach ($row['actions'] as $action => $url)
                    <flux:button
                        size="sm"
                        href="{{ $url }}"
                        wire:navigate>
                        @if ($action === 'edit')
                        <flux:icon.pencil class="size-4" />
                        @elseif($action == 'delete')
                        <flux:icon.trash class="size-4" />
                        @elseif($action == 'view')
                        <flux:icon.eye class="size-4" />
                        @endif
                    </flux:button>
                    @endforeach
                </td>
                @endif

            </tr>
            @empty
            <tr>
                @php
                $hasActions = !empty($rows) && !empty($rows[0]['actions']);
                @endphp

                <td colspan="{{ count($headers) + ($hasActions ? 1 : 0) }}" class="px-4 py-6 text-center text-sm text-gray-500">
                    {{ __($emptyLabel) }}
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
{{-- Mobile cards --}}
<div class="space-y-3 md:hidden">
    @forelse ($rows as $row)
    <div
        x-data="{ open: false }"
        class="rounded-lg border">
        {{-- Card header --}}
        <button
            type="button"
            @click="open = !open"
            class="w-full flex items-center justify-between p-4">
            <span class="font-medium">
                {{ $row['cells'][0] ?? '-' }}
            </span>

            <svg
                class="h-5 w-5 transition-transform"
                :class="{ 'rotate-180': open }"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        {{-- Collapsible content --}}
        <div
            x-show="open"
            x-collapse
            class="border-t p-4">
            <div class="divide-y divide-gray-200">
                @foreach (array_slice($row['cells'], 1) as $index => $cell)
                <div class="grid grid-cols-[auto,1fr] gap-x-4 py-2">
                    <div class="text-sm font-medium text-gray-700 whitespace-nowrap">
                        {{ __($headers[$index + 1]) }}
                    </div>

                    <div class="text-sm text-gray-900 break-words">
                        {{ $cell }}
                    </div>
                </div>
                @endforeach
            </div>

            <div class="w-full flex justify-end">
                @if (!empty($row['actions']))
                <div class="px-4 py-3 text-right">
                    @foreach ($row['actions'] as $action => $url)
                    <flux:button
                        size="sm"
                        href="{{ $url }}"
                        wire:navigate>
                        @if ($action === 'edit')
                        <flux:icon.pencil class="size-4" />
                        @elseif($action == 'delete')
                        <flux:icon.trash class="size-4" />
                        @elseif($action == 'view')
                        <flux:icon.eye class="size-4" />
                        @endif
                    </flux:button>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div class="text-sm text-gray-500">
        {{ __($emptyLabel) }}
    </div>
    @endforelse
</div>