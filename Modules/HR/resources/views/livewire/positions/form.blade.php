<form wire:submit.prevent="save" class="space-y-6">
    <livewire:core.fields.localized-input
        field="name"
        :value="$name"
        :label="__('hr::positions.fields.name')"
        :error="$errors->first('name')"
        :required="true" />
    <x-core::shared.form-field
        :label="__('hr::positions.fields.department')"
        :required="true" error="department_id">
        <flux:select wire:model.defer="department_id" error="department_id">
            <option value="">{{ __('hr::positions.placeholders.department') }}</option>
            @foreach ($this->departments as $department)
            <option value="{{ $department->id }}">
                {{ $department->name[app()->getLocale()] ?? '-' }}
            </option>
            @endforeach
        </flux:select>
    </x-core::shared.form-field>

    <x-core::shared.form-field
        :label="__('hr::positions.fields.grade')"
        :required="false">
        <flux:select wire:model.defer="grade_id" error="grade_id">
            <option value="">{{ __('hr::positions.placeholders.grade') }}</option>
            @foreach ($this->grades as $grade)
            <option value="{{ $grade->id }}">
                {{ $grade->name[app()->getLocale()] ?? '-' }}
            </option>
            @endforeach
        </flux:select>
    </x-core::shared.form-field>


    <livewire:core.fields.active-toggle
        wire:model.defer="is_active"
        :label="__('hr::positions.fields.is_active')"
        :required="false" />

    <div class="flex justify-end">
        <flux:button type="submit" variant="primary">
            {{ __('hr::positions.actions.save') }}
        </flux:button>
    </div>
</form>