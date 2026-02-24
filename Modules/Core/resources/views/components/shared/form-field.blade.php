@props([
'label',
'required' => false,
'error'=>false,
])

<div class="space-y-1">
    <div class="flex items-center gap-1 text-sm font-medium text-gray-700">
        <span>{{ $label }}</span>
        @if ($required)
        <x-core::shared.required />
        @else
        <x-core::shared.optional />
        @endif
    </div>

    <div>
        {{ $slot }}
    </div>
    @if ($error)
    <flux:error :name="$error" />
    @endif
</div>