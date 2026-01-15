<?php

namespace Modules\HR\Livewire\Departments;

use Livewire\Attributes\On;
use Livewire\Component;
use Modules\HR\Models\Department;

class Edit extends Component {
    public Department $department;
    #[On(Form::SAVED)]
    public function created() {
        $this->redirectRoute('hr.departments.index');
    }
    public function render() {
        return view('hr::livewire.departments.edit');
    }
}
