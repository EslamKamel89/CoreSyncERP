<?php

namespace Modules\HR\Livewire\Positions;

use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Core\Livewire\Filters\PerPageSelect;
use Modules\Core\Livewire\Filters\SelectFilter;
use Modules\Core\Livewire\Filters\SortSelect;
use Modules\Core\Livewire\Filters\StatusFilter;
use Modules\HR\Models\Department;
use Modules\HR\Models\Position;

class Index extends Component {
    use WithPagination;

    public string $search = '';

    public int $perPage = 10;

    public array $filters = [
        'department_id' => null,
        'status' => null,
    ];

    public ?string $sortColumn = null;

    public string $sortDirection = 'asc';

    #[Computed]
    public function positions(): array {
        $query = Position::indexQuery([
            'search' => $this->search,
            'department_id' => $this->filters['department_id'],
            'status' => $this->filters['status'],
            'sort_column' => $this->sortColumn,
            'sort_direction' => $this->sortDirection,
        ]);

        $paginator = $query->paginate($this->perPage);

        return [
            'list'  => Position::toListData($paginator),
            'links' => $paginator->links(),
        ];
    }

    #[On(PerPageSelect::UPDATED)]
    public function onPerPageUpdate(int $perPage): void {
        $this->perPage = $perPage;
        $this->resetPage();
    }

    #[On(StatusFilter::UPDATED)]
    public function onStatusFilterUpdate(?string $value): void {
        $this->filters['status'] = $value;
        $this->resetPage();
    }

    #[On(SelectFilter::UPDATED . '.department_id')]
    public function onDepartmentIdUpdate($value): void {
        $this->filters['department_id'] = $value === 'all' ? null : $value;
        $this->resetPage();
    }

    #[On(SortSelect::UPDATED)]
    public function onSortUpdate(array $payload): void {
        $this->sortColumn = $payload['column'];
        $this->sortDirection = $payload['direction'];
        $this->resetPage();
    }

    public function render() {
        $departments = Department::select(['id', 'name'])
            ->get()
            ->map(fn($row) => [
                'label' => $row->name[app()->getLocale()],
                'value' => $row->id,
            ])
            ->toArray();

        $sortOptions = [
            'status' => __('hr::employees.fields.status')
        ];

        return view(
            'hr::livewire.positions.index',
            [
                'departments' => $departments,
                'sortOptions' => $sortOptions,
            ]
        );
    }
}
