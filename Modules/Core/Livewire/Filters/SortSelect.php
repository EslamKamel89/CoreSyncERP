<?php

namespace Modules\Core\Livewire\Filters;

use Livewire\Component;

class SortSelect extends Component {
    const UPDATED = 'sort-select.updated';
    public array $options = [];

    public ?string $column = null;
    public string $direction = 'asc';
    public function updatedColumn(): void {
        $this->emitUpdated();
    }
    public function toggleDirection() {
        $this->direction  = $this->direction === 'asc' ?  'desc' :  'asc';
        $this->emitUpdated();
    }
    protected function emitUpdated(): void {
        $this->dispatch(self::UPDATED, [
            'column' => $this->column,
            'direction' => $this->direction,
        ]);
    }
    public function render() {
        return view('core::livewire.filters.sort-select');
    }
}
