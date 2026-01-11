<?php

namespace Modules\HR\Livewire\Positions;


use Livewire\Component;
use Livewire\Attributes\Computed;
use Modules\HR\Models\Position;
use Modules\Core\Traits\BuildsListData;

class Index extends Component {
    use BuildsListData;
    public string $search = '';
    #[Computed]
    public function positions() {
        $positionsPaginator = Position::query()
            ->with('department')
            ->when(
                $this->search !== '',
                fn($q) => $q->searchLocalizedJson('name', $this->search)
            )
            ->orderBy('id')
            ->paginate(10);
        $rows = $positionsPaginator->getCollection()
            ->map(function (Position $position) {
                return [
                    'cells' => [
                        $position->name[app()->getLocale()] ?? '-',
                        $position->department?->name[app()->getLocale()] ?? '-',
                    ],
                    'actions' => [
                        'edit' => route('hr.positions.edit', $position),
                    ],
                ];
            })->toArray();

        $listData = $this->makeListData(
            ['hr::hr.positions.title', 'hr::hr.departments.title'],
            $rows,
            'hr::hr.positions.empty'
        );
        return [
            'list' => $listData,
            'links' => $positionsPaginator->links(),
        ];
    }

    public function render() {
        return view('hr::livewire.positions.index');
    }
}
