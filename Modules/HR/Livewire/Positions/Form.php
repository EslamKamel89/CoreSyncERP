<?php

namespace Modules\HR\Livewire\Positions;

use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Modules\Core\Livewire\Fields\LocalizedInput;
use Modules\Core\Traits\NotifiesWithToast;
use Modules\HR\Models\Department;
use Modules\HR\Models\Grade;
use Modules\HR\Models\Position;

class Form extends Component {
    use NotifiesWithToast;
    const SAVED = 'department-form.saved';
    public ?Position $position = null;
    public ?int $department_id = null;
    public ?int $grade_id = null;
    public  array $name = [];
    public bool $is_active = true;
    public function mount(): void {
        if ($this->position) {
            $this->name = $this->position->name  ?? [];
            $this->is_active = $this->position->is_active;
            $this->department_id = $this->position->department_id;
            $this->grade_id = $this->position->grade_id;
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
                'department_id' => ['required', 'exists:departments,id'],
                'grade_id' => ['nullable', 'exists:grades,id'],
                'is_active' => ['boolean']
            ],
            messages: [],
            attributes: $this->validationAttributes(),
        );
        if ($this->position) {
            $this->position->update($validated);
        } else {
            $this->position = Position::create($validated);
        }
        $this->notifySaved();
        $this->dispatch(self::SAVED, $this->position->id);
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
        $attributes['department_id'] = __('hr::positions.fields.department');
        $attributes['grade_id'] = __('hr::positions.fields.grade');
        $attributes['is_active'] = __('hr::departments.fields.is_active');

        return $attributes;
    }
    #[Computed]
    public function departments() {
        return Department::where('is_active', true)->orderBy('id')->get();
    }
    #[Computed]
    public function grades() {
        return Grade::all();
    }
    public function render() {
        return view('hr::livewire.positions.form');
    }
}
