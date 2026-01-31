<?php

namespace Modules\HR\Livewire\Grades;

use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Core\Livewire\Filters\PerPageSelect;
use Modules\Core\Livewire\Filters\SelectFilter;
use Modules\Core\Livewire\Filters\SortSelect;
use Modules\Core\Livewire\Filters\StatusFilter;
use Modules\HR\Models\Department;
use Modules\HR\Models\Grade;
use Modules\HR\Models\Position;

class Index extends Component {
    use WithPagination;

    public string $search = '';
    public int $perPage = 10;

    public array $filters = [
        'status' => null,
    ];
    public ?string $sortColumn = null;
    public string $sortDirection = 'asc';


    #[Computed]
    public function grades(): array {
        $query = Grade::indexQuery([
            'search' => $this->search,
            'status' => $this->filters['status'],
            'sort_column' => $this->sortColumn,
            'sort_direction' => $this->sortDirection,
        ]);

        $paginator = $query->paginate($this->perPage);

        return [
            'list'  => Grade::toListData($paginator),
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
    #[On(SortSelect::UPDATED)]
    public function onSortUpdate(array $payload): void {
        $this->sortColumn = $payload['column'];
        $this->sortDirection = $payload['direction'];
        $this->resetPage();
    }

    public function render() {
        $sortOptions = [
            'created_at' => __('core::shared.created_at'),
        ];
        return view('hr::livewire.grades.index', [
            'sortOptions' => $sortOptions,
        ]);
    }
}
