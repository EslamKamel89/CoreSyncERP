<?php

namespace Modules\HR\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Core\Traits\JsonLocalizedSearch;
use Modules\HR\Database\Factories\DepartmentFactory;
use Modules\Core\Traits\BuildsListData;
use Illuminate\Pagination\LengthAwarePaginator;

class Department extends Model {
    use HasFactory, JsonLocalizedSearch, BuildsListData;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'is_active',
        "external_id",
        "meta",
        "status",
        "created_by",
    ];
    protected function casts(): array {
        return [
            'is_active' => 'boolean',
            'name' => 'array',
            'meat' => 'array',
        ];
    }

    protected static function newFactory(): DepartmentFactory {
        return DepartmentFactory::new();
    }
    public function positions(): HasMany {
        return $this->hasMany(Position::class);
    }
    public function employees(): HasMany {
        return $this->hasMany(Employee::class);
    }
    public function scopeSearch($query, ?string $search): Builder {
        return $query ? $query->where(function (Builder $q) use ($search) {
            $q->searchLocalizedJson('name', $search);
        }) : $query;
    }
    public function scopeFilterByStatus(Builder $query, ?string $status): Builder {
        return match ($status) {
            'active'   => $query->where('is_active', true),
            'inactive' => $query->where('is_active', false),
            default    => $query,
        };
    }
    public function scopeSort(Builder $query, ?string $column = null, string $direction = 'asc') {
        return $column
            ? $query->orderBy($column, $direction)
            : $query->orderBy('id');
    }
    public static function indexQuery(array $params): Builder {
        return static::query()
            ->search($params['search'] ?? null)
            ->filterByStatus($params['status'] ?? null)
            ->sort(
                $params['sort_column'] ?? null,
                $params['sort_direction'] ?? 'asc'
            );
    }
    public static function toListData(LengthAwarePaginator $paginator): array {
        $rows = $paginator->getCollection()->map(function (self $department) {
            return [
                'cells' =>  [
                    $department->name[app()->getLocale()] ?? __('core::shared.empty'),
                    $department->is_active
                        ? __('core::shared.active')
                        : __('core::shared.inactive'),
                ],
                'actions' => [
                    'edit' => route('hr.departments.edit', $department),
                ],
            ];
        })->toArray();
        return self::makeListData(
            headers: [
                'hr::hr.departments.title',
                'hr::employees.fields.status',
            ],
            rows: $rows,
            emptyLabel: 'hr::hr.departments.empty'
        );
    }
}
