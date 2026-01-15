<flux:field variant="inline" class="w-fit space-x-2">
    <flux:label>{{ $label ?? "Active" }}</flux:label>
    <flux:switch wire:model="value" />

</flux:field>