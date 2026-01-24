<div class="flex flex-wrap items-end gap-3">
    <div class="w-32">
        <flux:select wire:model.live="perPage" label="{{ __('core::shared.per_page') }}">
            @foreach ($perPageOptions as $option )
            <flux:select.option :key="$option" :value="$option">{{ $option }}</flux:select.option>
            @endforeach
        </flux:select>
    </div>
</div>