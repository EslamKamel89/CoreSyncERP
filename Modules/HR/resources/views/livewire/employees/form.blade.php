<form wire:submit.prevent="save" class="space-y-6">
    <!--
    <flux:input
    wire:model.defer="employee_number"
    :label="__('hr::employees.fields.employee_number')"
    error="employee_number" />
-->

    <flux:input
        wire:model.defer="name"
        :label="__('hr::employees.fields.name')"
        error="name" />

    <livewire:core.fields.localized-input
        field="display_name"
        :value="$display_name"
        :label="__('hr::employees.fields.display_name')"
        :error="$errors->first('display_name')" />

    <flux:select wire:model.defer="department_id"
        :label="__('hr::employees.fields.department')"
        error="department_id">
        <option value="">{{ __('hr::employees.placeholders.department') }}</option>
        @foreach ($this->departments as $department)
        <option value="{{ $department->id }}">
            {{ $department->name[app()->getLocale()] ?? '-' }}
        </option>
        @endforeach
    </flux:select>

    <flux:select wire:model.defer="position_id"
        :label="__('hr::employees.fields.position')"
        error="position_id">
        <option value="">{{ __('hr::employees.placeholders.position') }}</option>
        @foreach ($this->positions as $position)
        <option value="{{ $position->id }}">
            {{ $position->name[app()->getLocale()] ?? '-' }}
        </option>
        @endforeach
    </flux:select>

    <flux:select wire:model.defer="grade_id"
        :label="__('hr::employees.fields.grade')"
        error="grade_id">
        <option value="">{{ __('hr::employees.placeholders.grade') }}</option>
        @foreach ($this->grades as $grade)
        <option value="{{ $grade->id }}">
            {{ $grade->name[app()->getLocale()] ?? '-' }}
        </option>
        @endforeach
    </flux:select>

    <flux:input
        type="date"
        wire:model.defer="hire_date"
        :label="__('hr::employees.fields.hire_date')"
        error="hire_date" />

    <flux:input
        type="number"
        step="0.01"
        wire:model.defer="base_salary"
        :label="__('hr::employees.fields.base_salary')"
        error="base_salary" />

    <livewire:core.fields.active-toggle
        wire:model.defer="is_active"
        :label="__('hr::employees.fields.is_active')" />

    <div class="flex justify-end">
        <flux:button type="submit" variant="primary">
            {{ __('hr::employees.actions.save') }}
        </flux:button>
    </div>
</form>