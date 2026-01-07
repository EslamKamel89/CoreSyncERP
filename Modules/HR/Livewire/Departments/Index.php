<?php

namespace Modules\HR\Livewire\Departments;


use Livewire\Component;
use Livewire\Attributes\Computed;
use Modules\HR\Models\Department;

class Index extends Component {
    public string $search = '';

    #[Computed]
    public function departments() {
        $locales = array_keys(config('core.locales.availableLocales'));

        return Department::query()
            ->when($this->search !== '',  fn($q) => $q->searchLocalizedJson('name', $this->search))
            ->orderBy('id')
            ->paginate(10);
    }
    public function render() {
        return view('hr::livewire.departments.index');
    }
}
