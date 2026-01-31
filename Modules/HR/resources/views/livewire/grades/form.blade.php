<form wire:submit.prevent="save" class="space-y-6">

    <livewire:core.fields.localized-input
        field="name"
        :value="$name"
        :label="__('hr::grades.fields.name')"
        :error="$errors->first('name')"
        :required="true" />

    <x-core::shared.form-field
        :label="__('hr::grades.fields.base_salary')"
        :required="false">
        <flux:input
            type="number"
            step="0.01"
            wire:model.defer="base_salary"
            error="base_salary" />
    </x-core::shared.form-field>

    <livewire:core.fields.active-toggle
        wire:model.defer="is_active"
        :label="__('hr::grades.fields.is_active')"
        :required="false" />

    <div class="flex justify-end">
        <flux:button type="submit" variant="primary">
            {{ __('hr::grades.actions.save') }}
        </flux:button>
    </div>
</form>