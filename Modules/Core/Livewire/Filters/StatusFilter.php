<?php

namespace Modules\Core\Livewire\Filters;

use Livewire\Component;

class StatusFilter extends Component {
    const UPDATED = 'status-filter.updated';

    public ?string $value = null;

    public function updatedValue(): void {
        $this->dispatch(self::UPDATED, $this->value);
    }
    public function render() {
        return view('core::livewire.filters.status-filter');
    }
}
