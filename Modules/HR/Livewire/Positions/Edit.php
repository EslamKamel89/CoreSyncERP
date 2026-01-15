<?php

namespace Modules\HR\Livewire\Positions;

use Livewire\Attributes\On;
use Livewire\Component;
use Modules\HR\Models\Position;

class Edit extends Component {
    public Position $position;
    #[On(Form::SAVED)]
    public function created() {
        $this->redirectRoute('hr.positions.index');
    }
    public function render() {
        return view('hr::livewire.positions.edit');
    }
}
