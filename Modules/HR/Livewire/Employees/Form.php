<?php

namespace Modules\HR\Livewire\Employees;

use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Modules\Core\Livewire\Fields\LocalizedInput;
use Modules\Core\Traits\NotifiesWithToast;
use Modules\HR\Models\Department;
use Modules\HR\Models\Position;
use Modules\HR\Models\Grade;
use Modules\HR\Models\Employee;

class Form extends Component {
    use NotifiesWithToast;

    public const SAVED = 'employee-form.saved';

    public ?Employee $employee = null;

    public string $employee_number = '';
    public string $name = '';
    public array $display_name = [];

    public ?int $department_id = null;
    public ?int $position_id = null;
    public ?int $grade_id = null;

    public ?string $hire_date = null;
    public ?float $base_salary = null;

    public bool $is_active = true;

    public function mount(): void {
        if ($this->employee) {
            $this->employee_number = $this->employee->employee_number;
            $this->name            = $this->employee->name;
            $this->display_name    = $this->employee->display_name ?? [];
            $this->department_id   = $this->employee->department_id;
            $this->position_id     = $this->employee->position_id;
            $this->grade_id        = $this->employee->grade_id;
            $this->hire_date       = $this->employee->hire_date?->toDateString();
            $this->base_salary     = $this->employee->base_salary;
            $this->is_active       = $this->employee->is_active;
        }
    }

    #[On(LocalizedInput::UPDATE)]
    public function updateDisplayName(array $payload): void {
        if ($payload['field'] === 'display_name') {
            $this->display_name = $payload['value'];
        }
    }

    public function save(): void {
        $validated = $this->validate(
            rules: [
                // 'employee_number' => ['required', 'string', 'max:50'],
                'name'            => ['required', 'string', 'max:255'],
                'display_name'    => ['nullable', 'array'],
                'display_name.*'  => ['nullable', 'string', 'max:255'],

                'department_id' => ['required', 'exists:departments,id'],
                'position_id'   => ['required', 'exists:positions,id'],
                'grade_id'      => ['nullable', 'exists:grades,id'],

                'hire_date'   => ['required', 'date'],
                'base_salary' => ['nullable', 'numeric', 'min:0'],
                'is_active'   => ['boolean'],
            ],
            attributes: $this->validationAttributes()
        );

        if ($this->employee) {
            $this->employee->update($validated);
        } else {
            $this->employee = Employee::create($validated);
        }

        $this->notifySaved();
        $this->dispatch(self::SAVED, $this->employee->id);
    }

    protected function validationAttributes(): array {
        $attributes = [];

        foreach (array_keys(config('core.locales.availableLocales')) as $locale) {
            $attributes["display_name.$locale"] =
                __('hr::employees.fields.display_name') .
                ' (' . __('core::locales.' . $locale) . ')';
        }

        return array_merge($attributes, [
            'employee_number' => __('hr::employees.fields.employee_number'),
            'name'            => __('hr::employees.fields.name'),
            'department_id'   => __('hr::employees.fields.department'),
            'position_id'     => __('hr::employees.fields.position'),
            'grade_id'        => __('hr::employees.fields.grade'),
            'hire_date'       => __('hr::employees.fields.hire_date'),
            'base_salary'     => __('hr::employees.fields.base_salary'),
            'is_active'       => __('hr::employees.fields.is_active'),
        ]);
    }

    #[Computed]
    public function departments() {
        return Department::where('is_active', true)->orderBy('id')->get();
    }

    #[Computed]
    public function positions() {
        return Position::where('is_active', true)->where('department_id', $this->department_id)->orderBy('id')->get();
    }

    #[Computed]
    public function grades() {
        return Grade::all();
    }

    public function render() {
        return view(
            'hr::livewire.employees.form',
        );
    }
}
