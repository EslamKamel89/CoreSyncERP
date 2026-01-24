<div class="flex flex-wrap items-end gap-3">
    <div class="w-32">
        <flux:select wire:model.live="value" label="{{ __('core::shared.status') }}">
            <flux:select.option value="">{{ __('core::shared.all') }}</flux:select.option>
            <flux:select.option value="active">{{ __('core::shared.active') }}</flux:select.option>
            <flux:select.option value="inactive">{{ __('core::shared.inactive') }}</flux:select.option>
        </flux:select>
    </div>
</div>