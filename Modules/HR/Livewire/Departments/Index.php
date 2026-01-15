<?php

namespace Modules\HR\Livewire\Departments;


use Livewire\Component;
use Livewire\Attributes\Computed;
use Modules\Core\Traits\BuildsListData;
use Modules\HR\Models\Department;

class Index extends Component {
    use BuildsListData;
    public string $search = '';

    #[Computed]
    public function departments() {
        $locales = array_keys(config('core.locales.availableLocales'));

        $departmentsPaginator =  Department::query()
            ->when($this->search !== '',  fn($q) => $q->searchLocalizedJson('name', $this->search))
            ->orderBy('id')
            ->paginate(10);
        $rows = $departmentsPaginator->getCollection()->map(function (Department $department) {
            return [
                'cells' =>  [$department->name[app()->getLocale()] ?? __('core::shared.empty')],
                'actions' => [
                    'edit' => route('hr.departments.edit', $department),
                ],
            ];
        })->toArray();
        $listData = $this->makeListData(
            headers: ['hr::hr.departments.title'],
            rows: $rows,
            emptyLabel: 'hr::hr.departments.empty'
        );
        return [
            'list' => $listData,
            'links' => $departmentsPaginator->links(),
        ];
    }
    public function render() {
        return view('hr::livewire.departments.index');
    }
}
