<?php

namespace Modules\Core\Livewire\Roles;

use Livewire\Component;
use Livewire\Attributes\Computed;
use Modules\Core\Models\Role;
use Modules\Core\Models\Permission;
use Modules\Core\Traits\NotifiesWithToast;

class Form extends Component {
    use NotifiesWithToast;

    public const SAVED = 'role-form.saved';

    public ?Role $role = null;
    public string $name = '';
    public array $selectedPermissions = [];
    public function mount(): void {
        if ($this->role) {
            $this->name = $this->role->name;
            $this->selectedPermissions =
                $this->role->permissions->pluck('id')->toArray();
        }
    }
    #[Computed]
    public function permissions() {
        return Permission::orderBy('name')->get();
    }
    protected function isProtected(): bool {
        return $this->role?->meta['system'] ?? false;
    }
    public function save() {
        $validated = $this->validate(
            rules: [
                'name' => ['required', 'string', 'max:255'],
                'selectedPermissions' => ['array'],
                'selectedPermissions.*' => ['exists:permissions,id'],
            ],
            attributes: $this->validationAttributes()
        );
        if ($this->role && $this->isProtected()) {
            abort(403, 'You are not allowed to edit system created Roles');
        }
        if ($this->role) {
            $this->role->update(['name' => $validated['name']]);
        } else {
            $this->role = Role::create([
                'name' => $validated['name'],
                'meta' => ['system' => false]
            ]);
        }
        $this->role->permissions()->sync($validated['selectedPermissions']);
        $this->notifySaved();
        $this->dispatch(self::SAVED, $this->role->id);
    }
    protected function validationAttributes(): array {
        return [
            'name' => __('core::roles.fields.name'),
            'selectedPermissions' => __('core::roles.fields.permissions'),
            'selectedPermissions.*' => __('core::roles.fields.permissions'),
        ];
    }
    public function render() {
        return view('core::livewire.roles.form');
    }
}
