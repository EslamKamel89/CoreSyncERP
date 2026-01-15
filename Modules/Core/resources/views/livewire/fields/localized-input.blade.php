    <div class="space-y-1">
        <div>{{ $label }}</div>
        <div class="flex flex-row w-full space-x-2 border-2 border-gray shadow rounded-lg my-2">
            @foreach ($this->locales as $locale => $label )
            <div class="w-full flex-1">
                <flux:input wire:model.live.debounce.900ms="value.{{ $locale }}" :placeholder="$label" />
            </div>
            @endforeach
        </div>
        @if ($error)
        <p class="text-sm text-red-600 mt-0">
            {{ $error }}
        </p>
        @endif
    </div>