<?php

namespace Modules\HR\Livewire\Grades;

use Livewire\Attributes\On;
use Livewire\Component;
use Modules\HR\Models\Grade;
use Modules\HR\Models\Position;

class Edit extends Component {
    public Grade $grade;

    #[On(Form::SAVED)]
    public function updated(): void {
        $this->redirectRoute('hr.grades.index');
    }

    public function render() {
        // dd($this->grade);
        return view('hr::livewire.grades.edit');
    }
}
