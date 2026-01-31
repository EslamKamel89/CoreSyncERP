<?php

namespace Modules\HR\Livewire\Grades;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\On;
use Livewire\Component;

class Create extends Component {
    use AuthorizesRequests;

    public function mount(): void {
        $this->authorize('hr.manage_structure');
    }

    #[On(Form::SAVED)]
    public function created(): void {
        $this->redirectRoute('hr.grades.index');
    }
    public function render() {
        return view('hr::livewire.grades.create');
    }
}
