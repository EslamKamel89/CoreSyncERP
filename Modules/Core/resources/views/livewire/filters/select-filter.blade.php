<div class="flex flex-wrap items-end gap-3">
    @if ($showTaps)
    <div class="flex flex-col">
        <div>{{ $label }}</div>
        <flux:button.group class="flex !flex-wrap">
            <flux:button :variant="$value == 'all' ? 'primary' : 'filled'" wire:click="setValue('all')" key='all' wire:target="all">{{ __('core::shared.all') }}</flux:button>
            @foreach ($options as $option )
            <flux:button :variant="$value == $option['value'] ? 'primary' : 'filled'" wire:click="setValue({{ $option['value'] }})" :key="$option['value']">{{ $option['label'] }}</flux:button>
            @endforeach
    </div>

    </flux:button.group>
    @else
    <div class="">
        <flux:select wire:model.live="value" :label="$label">
            <flux:select.option value="all">{{ __('core::shared.all') }}</flux:select.option>
            @foreach ($options as $option )
            <flux:select.option :value="$option['value']" :key="$option['value']">{{ $option['label'] }}</flux:select.option>
            @endforeach
        </flux:select>
    </div>
    @endif
</div>