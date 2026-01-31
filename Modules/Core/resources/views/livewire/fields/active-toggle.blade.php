<flux:field variant="inline" class="w-fit space-x-2">
    <div class="flex items-center gap-1">
        <flux:label>
            {{ $label ?? __('core::shared.active') }}
        </flux:label>

        @if ($required)
        <x-core::shared.required />
        @else
        <x-core::shared.optional />
        @endif
    </div>

    <flux:switch wire:model="value" />
</flux:field>