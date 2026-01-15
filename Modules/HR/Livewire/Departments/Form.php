<?php

namespace Modules\HR\Livewire\Departments;

use Livewire\Component;
use Livewire\Attributes\On;
use Modules\Core\Livewire\Fields\LocalizedInput;
use Modules\Core\Traits\NotifiesWithToast;
use Modules\HR\Models\Department;

class Form extends Component {
    use NotifiesWithToast;
    const SAVED = 'department-form.saved';
    public ?Department $department = null;
    public  array $name = [];
    public bool $is_active = true;
    public function mount(): void {
        if ($this->department) {
            $this->name = $this->department->name ?? [];
            $this->is_active = $this->department->is_active;
        }
    }
    #[On(LocalizedInput::UPDATE)]
    public function updateName(array $payload) {
        match ($payload['field']) {
            'name' => $this->name = $payload['value'],
            default => null,
        };
    }

    public function save() {
        $validated = $this->validate(
            rules: [
                'name' => ['required', 'array'],
                'name.*' => ['required', 'string', 'max:255'],
                'is_active' => ['boolean']
            ],
            messages: [],
            attributes: $this->validationAttributes(),
        );
        if ($this->department) {
            $this->department->update($validated);
        } else {
            $this->department = Department::create($validated);
        }
        $this->notifySaved();
        $this->dispatch(self::SAVED, $this->department->id);
    }
    protected function validationAttributes(): array {
        $attributes = [];

        $locales = array_keys(config('core.locales.availableLocales'));

        foreach ($locales as $locale) {
            $attributes["name.$locale"] =
                __('hr::departments.fields.name')
                . ' (' . __('core::locales.' . $locale) . ')';
        }

        $attributes['name'] = __('hr::departments.fields.name');
        $attributes['is_active'] = __('hr::departments.fields.is_active');

        return $attributes;
    }
    public function render() {
        return view('hr::livewire.departments.form');
    }
}
