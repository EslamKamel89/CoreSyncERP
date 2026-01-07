<?php

namespace Modules\HR\Livewire\Positions;


use Livewire\Component;
use Livewire\Attributes\Computed;
use Modules\HR\Models\Position;

class Index extends Component {
    public string $search = '';
    #[Computed]
    public function positions() {
        return Position::query()
            ->with('department')
            ->when(
                $this->search !== '',
                fn($q) => $q->searchLocalizedJson('name', $this->search)
            )
            ->orderBy('id')
            ->paginate(10);
    }

    public function render() {
        return view('hr::livewire.positions.index');
    }
}
