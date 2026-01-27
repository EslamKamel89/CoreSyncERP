<?php

namespace Modules\HR\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\HR\Database\Factories\EmployeeFactory;
use Modules\Core\Traits\JsonLocalizedSearch;
use Modules\Core\Traits\BuildsListData;

class Employee extends Model {
    use HasFactory, JsonLocalizedSearch, BuildsListData;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'department_id',
        'position_id',
        'grade_id',
        'name',
        'employee_number',
        'display_name',
        'hire_date',
        'base_salary',
        'is_active',
        "external_id",
        "meta",
        "status",
        "created_by",
    ];
    protected function casts(): array {
        return [
            'display_name' => 'array',
            'hire_date' => 'date',
            'base_salary' => 'decimal:4',
            'is_active' => 'boolean',
            'meta' => 'array',
        ];
    }

    protected static function newFactory(): EmployeeFactory {
        return EmployeeFactory::new();
    }
    public function department(): BelongsTo {
        return $this->belongsTo(Department::class);
    }
    public function position(): BelongsTo {
        return $this->belongsTo(Position::class);
    }
    public function grade(): BelongsTo {
        return $this->belongsTo(Grade::class);
    }
    public function user(): HasOne {
        return $this->hasOne(User::class);
    }
    public function scopeSearch(Builder $query, ?string $search): Builder {

        return $search ? $query->where(function ($q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%")
                ->orWhere('employee_number', 'LIKE', "%{$search}%")
                ->orWhere(fn($sub) =>
                $sub->searchLocalizedJson('display_name', $search));
        }) : $query;
    }
    public function scopeFilterByDepartment(Builder $query, ?int $departmentId): Builder {
        return $departmentId ?  $query->where('department_id', $departmentId) : $query;
    }
    public function scopeFilterByPosition(Builder $query, ?int $positionId): Builder {
        return $positionId ? $query->where('position_id', $positionId)  : $query;
    }
    public function scopeFilterByStatus(Builder $query, ?string $status): Builder {
        return match ($status) {
            'active' => $query->where('is_active', true),
            'inactive' => $query->where('is_active', false),
            default => $query,
        };
    }
    public function scopeSort(Builder $query, ?string $column = null, string $direction = 'asc'): Builder {
        return $column  ? $query->orderBy($column, $direction) : $query;
    }
    public static function indexQuery(array $params): Builder {
        return self::query()
            ->with(['department', 'position', 'grade'])
            ->search($params['search'] ?? null)
            ->filterByDepartment($params['department_id'] ?? null)
            ->filterByPosition($params['position_id'] ?? null)
            ->filterByStatus($params['status'] ?? null)
            ->sort(
                $params['sort_column'] ?? null,
                $params['sort_direction'] ?? 'asc'
            );
    }
    public static function toListData(LengthAwarePaginator $paginator) {
        $rows = $paginator->getCollection()
            ->map(function (self $employee) {
                return [
                    'cells' => [
                        $employee->department?->name[app()->getLocale()] ?? __('core::shared.empty'),
                        $employee->position?->name[app()->getLocale()] ?? __('core::shared.empty'),
                        $employee->grade?->name[app()->getLocale()] ?? __('core::shared.empty'),
                        $employee->name,
                        $employee->employee_number,
                        $employee->display_name[app()->getLocale()] ?? __('core::shared.empty'),
                        $employee->hire_date?->format('Y-m-d') ?? __('core::shared.empty'),
                        $employee->base_salary !== null
                            ? number_format($employee->base_salary, 2)
                            : __('core::shared.empty'),
                        $employee->is_active
                            ? __('core::shared.active')
                            : __('core::shared.inactive'),
                    ],
                    'actions' => [
                        'edit' => route('hr.employees.edit', $employee),
                    ],
                ];
            })
            ->toArray();
        return self::makeListData(
            headers: [
                'hr::hr.departments.title',
                'hr::hr.positions.title',
                'hr::hr.grades.title',
                'hr::employees.fields.name',
                'hr::employees.fields.employee_number',
                'hr::employees.fields.display_name',
                'hr::employees.fields.hire_date',
                'hr::employees.fields.base_salary',
                'hr::employees.fields.status',
            ],
            rows: $rows,
            emptyLabel: 'hr::hr.employees.empty'
        );
    }
}
