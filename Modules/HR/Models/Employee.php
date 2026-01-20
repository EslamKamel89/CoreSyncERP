<?php

namespace Modules\HR\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Core\Traits\JsonLocalizedSearch;
use Modules\HR\Database\Factories\EmployeeFactory;

class Employee extends Model {
    use HasFactory, JsonLocalizedSearch;

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
}
