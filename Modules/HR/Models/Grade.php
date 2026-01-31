<?php

namespace Modules\HR\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Core\Traits\BuildsListData;
use Modules\Core\Traits\JsonLocalizedSearch;
use Modules\HR\Database\Factories\GradeFactory;

class Grade extends Model {
    use HasFactory, JsonLocalizedSearch, BuildsListData;


    protected $fillable = [
        'name',
        'base_salary',
        "external_id",
        'is_active',
        "meta",
        "status",
        "created_by",
    ];

    protected function casts(): array {
        return [
            'name' => 'array',
            'base_salary' => 'decimal:4',
            'meta' => 'array',
            'is_active' => 'boolean',
        ];
    }

    protected static function newFactory(): GradeFactory {
        return GradeFactory::new();
    }
    public function positions(): HasMany {
        return $this->hasMany(Position::class);
    }
    public function employees(): HasMany {
        return $this->hasMany(Employee::class);
    }
    public function scopeSearch(Builder $query, ?string $search): Builder {
        if (!filled($search)) {
            return $query;
        }

        return $query->where(
            fn($q) =>
            $q->searchLocalizedJson('name', $search)
        );
    }
    public function scopeFilterByStatus(Builder $query, ?string $status): Builder {
        return match ($status) {
            'active'   => $query->where('is_active', true),
            'inactive' => $query->where('is_active', false),
            default    => $query,
        };
    }
    public function scopeSort(Builder $query, ?string $column, string $direction = 'asc'): Builder {
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
    public static function toListData(LengthAwarePaginator $paginator) {
        $rows = $paginator->getCollection()
            ->map(function (self $grade) {
                return [
                    'cells' => [
                        $grade->name[app()->getLocale()] ?? __('core::shared.empty'),
                        $grade->base_salary !== null
                            ? number_format($grade->base_salary, 2)
                            : __('core::shared.empty'),
                        $grade->is_active
                            ? __('core::shared.active')
                            : __('core::shared.inactive'),
                    ],
                    'actions' => [
                        'edit' => route('hr.grades.edit', $grade),
                    ],
                ];
            })
            ->toArray();
        return self::makeListData(
            headers: [
                'hr::hr.grades.title',
                'hr::grades.fields.base_salary',
                'hr::employees.fields.status',
            ],
            rows: $rows,
            emptyLabel: 'hr::hr.grades.empty'
        );
    }
}
