<?php

namespace Modules\Core\Livewire\Filters;

use Livewire\Component;

class PerPageSelect extends Component {
    const UPDATED = 'per-page-select.updated';

    /**
     * Per-page selection (predefined values only).
     */
    public int $perPage = 10;
    /**
     * Allowed per-page options (configurable).
     */
    public array $perPageOptions = [10, 25, 50];

    public function updatedPerPage(): void {
        $this->dispatch(self::UPDATED, $this->perPage);
    }
    public function render() {
        return view('core::livewire.filters.per-page-select');
    }
}
