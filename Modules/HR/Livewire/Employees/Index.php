<?php

namespace Modules\HR\Livewire\Employees;

use Livewire\Attributes\On;
use Livewire\Component;
use Modules\Core\Traits\BuildsListData;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use Modules\Core\Livewire\Filters\PerPageSelect;
use Modules\Core\Livewire\Filters\SelectFilter;
use Modules\Core\Livewire\Filters\SortSelect;
use Modules\Core\Livewire\Filters\StatusFilter;
use Modules\HR\Models\Department;
use Modules\HR\Models\Employee;
use Modules\HR\Models\Position;

class Index extends Component {
    use BuildsListData, WithPagination;
    public string $search = '';
    public int $perPage = 10;
    public array $filters = [
        'department_id' => null,
        'position_id' => null,
        'status' => null,
    ];
    public ?string $sortColumn = null;
    public string $sortDirection = 'asc';
    #[Computed]
    public function employees() {
        $query = Employee::query()
            ->with(['department', 'position', 'grade'])
            ->when($this->search !== '', function ($q) {
                return $q->where('name', 'LIKE', "%{$this->search}%")
                    ->orWhere('employee_number', 'LIKE', "%{$this->search}%")
                    ->orWhere('name', 'LIKE', "%{$this->search}%")
                    ->orWhere(fn($sub) => $sub->searchLocalizedJson('display_name', $this->search));
            })->when($this->filters['department_id'], function ($q) {
                return $q->where('department_id', $this->filters['department_id']);
            })->when($this->filters['position_id'], function ($q) {
                return $q->where('position_id', $this->filters['position_id']);
            });
        if ($this->filters['status'] === 'active') {
            $query->where('is_active', true);
        } elseif ($this->filters['status'] === 'inactive') {
            $query->where('is_active', false);
        }
        if ($this->sortColumn) {
            $query->orderBy($this->sortColumn, $this->sortDirection);
        } else {
            $query->orderBy('id');
        }
        $employeesPaginator = $query->paginate($this->perPage);
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
    #[On(PerPageSelect::UPDATED)]
    public function onPerPageUpdate(int $perPage) {
        $this->perPage = $perPage;
        $this->resetPage();
    }
    #[On(StatusFilter::UPDATED)]
    public function onStatusFilterUpdate(?string $value) {
        $this->filters['status'] = $value;
        $this->resetPage();
    }
    #[On(SelectFilter::UPDATED . '.department_id')]
    public function onDepartmentIdUpdate($value) {
        if ($value === 'all') {
            $this->filters['department_id'] = null;
        } else {
            $this->filters['department_id'] = $value;
        }
        $this->resetPage();
    }
    #[On(SelectFilter::UPDATED . '.position_id')]
    public function onPositionIdUpdate($value) {
        if ($value === 'all') {
            $this->filters['position_id'] = null;
        } else {
            $this->filters['position_id'] = $value;
        }
        $this->resetPage();
    }
    #[On(SortSelect::UPDATED)]
    public function onSortUpdate(array $payload) {
        $this->sortColumn = $payload['column'];
        $this->sortDirection = $payload['direction'];
        $this->resetPage();
    }
    public function render() {
        $departments = Department::select(['id', 'name',])->get()->map(function ($row) {
            return [
                'label' => $row->name[app()->getLocale()],
                'value' => $row->id,
            ];
        })->toArray();
        $positions = Position::select(['id', 'name',])->get()->map(function ($row) {
            return [
                'label' => $row->name[app()->getLocale()],
                'value' => $row->id,
            ];
        })->toArray();
        $sortOptions = [
            'hire_date' => __('hr::employees.fields.hire_date'),
            'base_salary' => __('hr::employees.fields.base_salary')
        ];

        return view(
            'hr::livewire.employees.index',
            ['departments' => $departments, 'positions' => $positions, 'sortOptions' => $sortOptions]
        );
    }
}
