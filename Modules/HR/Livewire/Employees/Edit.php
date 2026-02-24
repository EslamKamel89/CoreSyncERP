<?php

namespace Modules\HR\Livewire\Employees;

use Livewire\Component;
use Livewire\Attributes\On;
use Modules\HR\Models\Employee;

class Edit extends Component {
    public Employee $employee;
    public function mount(): void {
        $this->authorize('hr.manage_structure');
    }
    #[On(Form::SAVED)]
    public function updated(): void {
        $this->redirectRoute('hr.employees.index');
    }
    public function render() {
        return view('hr::livewire.employees.edit');
    }
}
