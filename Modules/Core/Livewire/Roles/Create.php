<?php

namespace Modules\Core\Livewire\Roles;

use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Livewire\Attributes\On;

class Create extends Component {
    use AuthorizesRequests;
    public function mount(): void {
        $this->authorize('system.manage_roles');
    }
    #[On(Form::SAVED)]
    public function created(): void {
        $this->redirectRoute('core.roles.index');
    }
    public function render() {
        return view('core::livewire.roles.create');
    }
}
