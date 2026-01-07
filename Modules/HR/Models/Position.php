<?php

namespace Modules\HR\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\HR\Database\Factories\PositionFactory;
use Modules\Core\Traits\JsonLocalizedSearch;

class Position extends Model {
    use HasFactory, JsonLocalizedSearch;

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
}
