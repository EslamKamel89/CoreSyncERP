<?php

namespace Modules\Core\Livewire\Roles;

use Livewire\Component;

use Livewire\Attributes\On;
use Modules\Core\Models\Role;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Edit extends Component {
    use AuthorizesRequests;
    public Role $role;
    public function mount(): void {
        if ($this->role->meta['system'] ?? false) {
            abort(403, 'You are not allowed to edit system created Roles');
        }
        $this->authorize('system.manage_roles');
    }
    #[On(Form::SAVED)]
    public function updated(): void {
        $this->redirectRoute('core.roles.index');
    }
    public function render() {
        return view('core::livewire.roles.edit');
    }
}
