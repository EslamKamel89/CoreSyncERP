<?php

namespace Modules\HR\Livewire\Employees;

use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\On;

class Create extends Component {
    use AuthorizesRequests;

    public function mount(): void {
        $this->authorize('hr.manage_structure');
    }
    #[On(Form::SAVED)]
    public function created(): void {
        $this->redirectRoute('hr.employees.index');
    }
    public function render() {
        return view('hr::livewire.employees.create');
    }
}
