<?php

namespace Modules\HR\Livewire\Departments;

use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Create extends Component {
    use AuthorizesRequests;

    public function mount(): void {
        $this->authorize('hr.manage_structure');
    }

    #[On(Form::SAVED)]
    public function created() {
        $this->redirectRoute('hr.departments.index');
    }

    public function render() {
        return view('hr::livewire.departments.create');
    }
}
