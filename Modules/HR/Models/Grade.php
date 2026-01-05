<?php

namespace Modules\HR\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\HR\Database\Factories\GradeFactory;

class Grade extends Model {
    use HasFactory;


    protected $fillable = [
        'name',
        'base_salary',
        "external_id",
        "meta",
        "status",
        "created_by",
    ];

    protected function casts(): array {
        return [
            'name' => 'array',
            'base_salary' => 'decimal:4',
            'meta' => 'array',
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
}
