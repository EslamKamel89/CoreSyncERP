<form wire:submit.prevent="save" class="space-y-6">
    <x-core::shared.form-field
        :label="__('core::roles.fields.name')"
        :required="true" error="name">
        <flux:input
            wire:model.defer="name"
            error="name" />
    </x-core::shared.form-field>
    <div class="space-y-2">
        <label class="text-sm font-medium">
            {{ __('core::roles.fields.permissions') }}
        </label>
        <div class="grid grid-cols-2 gap-3">
            @foreach($this->permissions as $permission)
            <label class="flex items-center gap-2">
                <input
                    type="checkbox"
                    value="{{ $permission->id }}"
                    wire:model.defer="selectedPermissions"
                    class="rounded border-gray-300">
                <span>{{ $permission->name }}</span>
            </label>
            @endforeach
        </div>
    </div>

    <div class="flex justify-end">
        <flux:button type="submit" variant="primary">
            {{ __('core::roles.actions.save') }}
        </flux:button>
    </div>
</form>