<?php

namespace Modules\Core\Livewire\Roles;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use Modules\Core\Models\Role;
use Modules\Core\Traits\BuildsListData;

class Index extends Component {
    use WithPagination, BuildsListData;
    public string $search = '';
    public int $perPage = 10;
    public ?string $sortColumn = null;
    public string $sortDirection = 'asc';

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
        return view('core::livewire.roles.index');
    }
}
