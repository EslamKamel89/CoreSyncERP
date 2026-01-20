<?php

namespace Modules\HR\Livewire\Employees;

use Livewire\Component;
use Modules\Core\Traits\BuildsListData;
use Livewire\Attributes\Computed;
use Modules\HR\Models\Employee;

class Index extends Component {
    use BuildsListData;
    public string $search = '';
    #[Computed]
    public function employees() {
        $employeesPaginator = Employee::query()
            ->with(['department', 'position', 'grade'])
            ->when($this->search !== '', function ($q) {
                return $q->where('name', 'LIKE', "%{$this->search}%")
                    ->orWhere('employee_number', 'LIKE', "%{$this->search}%")
                    ->orWhere('name', 'LIKE', "%{$this->search}%")
                    ->orWhere(fn($sub) => $sub->searchLocalizedJson('display_name', $this->search));
            })->orderBy('id')
            ->paginate(10);
        $rows = $employeesPaginator->getCollection()
            ->map(function (Employee $employee) {
                return [
                    'cells' => [
                        $employee->department?->name[app()->getLocale()] ?? __('core::shared.empty'),
                        $employee->position?->name[app()->getLocale()] ?? __('core::shared.empty'),
                        $employee->grade?->name[app()->getLocale()] ?? __('core::shared.empty'),
                        $employee->name,
                        $employee->employee_number,
                        $employee->display_name[app()->getLocale()] ?? __('core::shared.empty'),
                        $employee->hire_date?->format('Y-m-d') ?? __('core::shared.empty'),
                        $employee->base_salary !== null
                            ? number_format($employee->base_salary, 2)
                            : __('core::shared.empty'),
                        $employee->is_active
                            ? __('core::shared.active')
                            : __('core::shared.inactive'),
                    ],
                    'actions' => [
                        'edit' => route('hr.employees.edit', $employee),
                    ],
                ];
            })->toArray();
        $listData = $this->makeListData(
            [
                'hr::hr.departments.title',
                'hr::hr.positions.title',
                'hr::hr.grades.title',
                'hr::employees.fields.name',
                'hr::employees.fields.employee_number',
                'hr::employees.fields.display_name',
                'hr::employees.fields.hire_date',
                'hr::employees.fields.base_salary',
                'hr::employees.fields.status',
            ],
            $rows,
            'hr::hr.employees.empty'
        );
        return [
            'list'  => $listData,
            'links' => $employeesPaginator->links(),
        ];
    }
    public function render() {
        return view('hr::livewire.employees.index');
    }
}
