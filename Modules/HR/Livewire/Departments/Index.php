<?php

namespace Modules\HR\Livewire\Departments;


use Livewire\Component;
use Livewire\Attributes\Computed;
use Modules\Core\Traits\BuildsListData;
use Modules\HR\Models\Department;
use Livewire\Attributes\On;
use Modules\Core\Livewire\Filters\PerPageSelect;
use Modules\Core\Livewire\Filters\StatusFilter;
use Livewire\WithPagination;

class Index extends Component {
    use BuildsListData, WithPagination;
    public string $search = '';
    public int $perPage = 10;
    public array $filters = [
        'status' => null,
    ];
    public ?string $sortColumn = null;
    public string $sortDirection = 'asc';
    #[Computed]
    public function departments() {
        $query = Department::indexQuery([
            'search' => $this->search,
            'status' => $this->filters['status'],
            'sort_column' => $this->sortColumn,
            'sort_direction' => $this->sortDirection,
        ]);
        $paginator = $query->paginate($this->perPage);
        return [
            'list' => Department::toListData($paginator),
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
    public function render() {
        $sortOptions = [
            'status' => __('hr::employees.fields.status')
        ];
        return view('hr::livewire.departments.index', ['sortOptions' => $sortOptions]);
    }
}
