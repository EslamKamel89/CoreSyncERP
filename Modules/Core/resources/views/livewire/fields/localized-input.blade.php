<div class="space-y-1">
    <div class="flex items-center gap-1">
        <span>{{ $label }}</span>

        @if ($required)
        <x-core::shared.required />
        @else
        <x-core::shared.optional />
        @endif
    </div>

    <div class="flex flex-row w-full space-x-2 border-2 border-gray shadow rounded-lg my-2">
        @foreach ($this->locales as $locale => $localeLabel)
        <div class="w-full flex-1">
            <flux:input
                wire:model.live.debounce.900ms="value.{{ $locale }}"
                :placeholder="$localeLabel" />
        </div>
        @endforeach
    </div>

    @if ($error)
    <p class="text-sm text-red-600 mt-0">
        {{ $error }}
    </p>
    @endif
</div>