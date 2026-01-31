<?php

namespace Modules\HR\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\HR\Database\Factories\PositionFactory;
use Modules\Core\Traits\JsonLocalizedSearch;
use Modules\Core\Traits\BuildsListData;

class Position extends Model {
    use HasFactory, JsonLocalizedSearch, BuildsListData;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'department_id',
        'grade_id',
        'name',
        'is_active',
        "external_id",
        "meta",
        "status",
        "created_by",
    ];

    protected static function newFactory(): PositionFactory {
        return PositionFactory::new();
    }
    protected function casts(): array {
        return [
            'name' => 'array',
            'is_active' => 'boolean',
            'meta' => 'array',
        ];
    }

    public function department(): BelongsTo {
        return $this->belongsTo(Department::class);
    }
    public function grade(): BelongsTo {
        return $this->belongsTo(Grade::class);
    }
    public function employees(): HasMany {
        return $this->hasMany(Employee::class);
    }
    public function scopeWithRelations(Builder $query) {
        return $query->with(['department', 'grade']);
    }
    public function scopeSearch(Builder $query, ?string $search): Builder {
        if (!filled($search)) {
            return $query;
        }
        return $query->where(function ($q) use ($search) {
            $q->searchLocalizedJson('name', $search);
        });
    }
    public function scopeFilterByDepartment($query, ?int $departmentId): Builder {
        return $departmentId
            ? $query->where('department_id', $departmentId)
            : $query;
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
            ->withRelations()
            ->search($params['search'] ?? null)
            ->filterByDepartment($params['department_id'] ?? null)
            ->filterByStatus($params['status'] ?? null)
            ->sort(
                $params['sort_column'] ?? null,
                $params['sort_direction'] ?? 'asc'
            );
    }
    public static function toListData($paginator): array {
        $rows = $paginator->getCollection()
            ->map(function (self $position) {
                return [
                    'cells' => [
                        $position->department?->name[app()->getLocale()] ?? __('core::shared.empty'),
                        $position->name[app()->getLocale()] ?? __('core::shared.empty'),
                        $position->grade?->name[app()->getLocale()] ?? __('core::shared.empty'),
                        $position->is_active
                            ? __('core::shared.active')
                            : __('core::shared.inactive'),
                    ],
                    'actions' => [
                        'edit' => route('hr.positions.edit', $position),
                    ],
                ];
            })
            ->toArray();

        return self::makeListData(
            headers: [
                'hr::hr.departments.title',
                'hr::hr.positions.title',
                'hr::hr.grades.title',
                'hr::employees.fields.status',
            ],
            rows: $rows,
            emptyLabel: 'hr::hr.positions.empty'
        );
    }
}
