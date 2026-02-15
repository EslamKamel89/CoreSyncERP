<?php

namespace Modules\Core\Models;

use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Core\Traits\BuildsListData;

class Role extends SpatieRole {
    use BuildsListData;
    protected $fillable = [
        'name',
        'guard_name',

        // White-label
        'external_id',
        'meta',
        'status',
    ];
    protected $casts = [
        'meta' => 'array',
    ];
    public function scopeSearch(Builder $query, ?string $search): Builder {
        return $search
            ? $query->where('name', 'like', "%{$search}%")
            : $query;
    }
    public function scopeSort(Builder $query, ?string $column = null, string $direction = 'asc'): Builder {
        return $column
            ? $query->orderBy($column, $direction)
            : $query->orderBy('id');
    }
    public static function indexQuery(array $params): Builder {
        return self::query()
            ->with('permissions')
            ->search($params['search'] ?? null)
            ->sort(
                $params['sort_column'] ?? null,
                $params['sort_direction'] ?? 'asc'
            );
    }
    public static function toListData(LengthAwarePaginator $paginator): array {
        $rows = $paginator->getCollection()
            ->map(function (self $role) {
                return [
                    'cells' => [
                        $role->name,
                        $role->permissions->count(),
                        $role->meta['system'] ?? false
                            ? __('core::shared.system')
                            : __('core::shared.custom'),
                    ],
                    'actions' => [
                        'edit' => route('core.roles.edit', $role),
                    ],
                ];
            })->toArray();
        return self::makeListData(
            headers: [
                'core::roles.fields.name',
                'core::roles.fields.permissions_count',
                'core::roles.fields.type',
            ],
            rows: $rows,
            emptyLabel: 'core::roles.empty'
        );
    }
}
