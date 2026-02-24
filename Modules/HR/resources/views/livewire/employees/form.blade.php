<form wire:submit.prevent="save" class="space-y-6">
    <x-core::shared.form-field
        :label="__('hr::employees.fields.name')"
        :required="true" error="name">
        <flux:input
            wire:model.defer="name"
            error="name" />
    </x-core::shared.form-field>

    <livewire:core.fields.localized-input
        field="display_name"
        :value="$display_name"
        :label="__('hr::employees.fields.display_name')"
        :error="$errors->first('display_name')"
        :required="true" />

    <x-core::shared.form-field
        :label="__('hr::employees.fields.department')"
        :required="true" error="department_id">
        <flux:select
            wire:model.live="department_id"
            error="department_id">
            <option value="">{{ __('hr::employees.placeholders.department') }}</option>
            @foreach ($this->departments as $department)
            <option value="{{ $department->id }}">
                {{ $department->name[app()->getLocale()] ?? '-' }}
            </option>
            @endforeach
        </flux:select>
    </x-core::shared.form-field>

    <x-core::shared.form-field
        :label="__('hr::employees.fields.position')"
        :required="true">
        <flux:select
            wire:model.live="position_id"
            description="{{ $department_id ? '':__('hr::employees.create.select_department_first') }}"
            error="position_id">
            <option value="">{{ __('hr::employees.placeholders.position') }}</option>
            @foreach ($this->positions as $position)
            <option value="{{ $position->id }}">
                {{ $position->name[app()->getLocale()] ?? '-' }}
            </option>
            @endforeach
        </flux:select>

    </x-core::shared.form-field>

    <x-core::shared.form-field
        :label="__('hr::employees.fields.grade')"
        :required="false">
        <flux:select
            wire:model.defer="grade_id"
            error="grade_id">
            <option value="">{{ __('hr::employees.placeholders.grade') }}</option>
            @foreach ($this->grades as $grade)
            <option value="{{ $grade->id }}">
                {{ $grade->name[app()->getLocale()] ?? '-' }}
            </option>
            @endforeach
        </flux:select>
    </x-core::shared.form-field>

    <x-core::shared.form-field
        :label="__('hr::employees.fields.hire_date')"
        :required="true" error="hire_date">
        <flux:input
            type="date"
            wire:model.defer="hire_date"
            error="hire_date" />
    </x-core::shared.form-field>

    <x-core::shared.form-field
        :label="__('hr::employees.fields.base_salary')"
        :required="false" error="base_salary">
        <flux:input
            type="number"
            step="0.01"
            wire:model.defer="base_salary"
            error="base_salary" />
    </x-core::shared.form-field>

    <livewire:core.fields.active-toggle
        wire:model.defer="is_active"
        :label="__('hr::employees.fields.is_active')"
        :required="false" />

    <div class="flex justify-end">
        <flux:button type="submit" variant="primary">
            {{ __('hr::employees.actions.save') }}
        </flux:button>
    </div>
</form>