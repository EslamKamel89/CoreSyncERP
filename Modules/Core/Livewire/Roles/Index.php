<?php

namespace Modules\Core\Livewire\Roles;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Modules\Core\Livewire\Filters\PerPageSelect;
use Modules\Core\Livewire\Filters\SortSelect;
use Modules\Core\Models\Role;
use Modules\Core\Traits\BuildsListData;

class Index extends Component {
    use WithPagination, BuildsListData, AuthorizesRequests;
    public string $search = '';
    public int $perPage = 10;
    public ?string $sortColumn = null;
    public string $sortDirection = 'asc';
    public function mount(): void {
        $this->authorize('system.manage_roles');
    }
    #[On(PerPageSelect::UPDATED)]
    public function onPerPageUpdate(int $perPage) {
        $this->perPage = $perPage;
        $this->resetPage();
    }
    #[On(SortSelect::UPDATED)]
    public function onSortUpdate(array $payload) {
        $this->sortColumn = $payload['column'];
        $this->sortDirection = $payload['direction'];
        $this->resetPage();
    }
    #[Computed]
    public function roles() {
        $query = Role::indexQuery([
            'search' => $this->search,
            'sort_column' => $this->sortColumn,
            'sort_direction' => $this->sortDirection,
        ]);

        $paginator = $query->paginate($this->perPage);

        return [
            'list'  => Role::toListData($paginator),
            'links' => $paginator->links(),
        ];
    }
    public function render() {
        $sortOptions = [
            'name' => __('core::roles.fields.name'),
        ];
        return view('core::livewire.roles.index', ['sortOptions' => $sortOptions]);
    }
}
