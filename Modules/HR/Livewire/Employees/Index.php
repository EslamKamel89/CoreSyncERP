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
        $query = Employee::indexQuery([
            'search' => $this->search,
            'department_id' => $this->filters['department_id'],
            'position_id' => $this->filters['position_id'],
            'status' => $this->filters['status'],
            'sort_column' => $this->sortColumn,
            'sort_direction' => $this->sortDirection,
        ]);
        $paginator = $query->paginate($this->perPage);
        return [
            'list'  => Employee::toListData($paginator),
            'links' => $paginator->links(),
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
