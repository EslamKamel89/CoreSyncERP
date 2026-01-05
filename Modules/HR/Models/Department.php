<?php

namespace Modules\HR\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\HR\Database\Factories\DepartmentFactory;

class Department extends Model {
    use HasFactory;

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
}
