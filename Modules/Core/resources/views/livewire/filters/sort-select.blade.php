<div class="flex items-end gap-2">
    <div class="w-40">
        <flux:select
            wire:model.live="column"
            :label="__('core::shared.sort_by')">
            <flux:select.option value="">
                {{ __('core::shared.none') }}
            </flux:select.option>

            @foreach ($options as $key => $text)
            <flux:select.option :value="$key">
                {{ $text }}
            </flux:select.option>
            @endforeach
        </flux:select>
    </div>

    <flux:button
        variant="filled"
        wire:click="toggleDirection"
        :disabled="!$column">
        @if ($direction === 'asc')
        <flux:icon.chevron-double-up />
        @else
        <flux:icon.chevron-double-down />
        @endif
    </flux:button>
</div>