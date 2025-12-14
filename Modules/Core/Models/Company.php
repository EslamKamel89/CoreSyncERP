<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Core\Database\Factories\CompanyFactory;


class Company extends Model {
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        "name",
        "legal_name",
        "tax_number",
        "base_currency",
        "timezone",
        "locale",
        "fiscal_year_start",
        "external_id",
        "meta",
        "status",
        "created_by",
    ];
    protected $casts  = [
        'meta' => 'array'
    ];

    protected static function newFactory(): CompanyFactory {
        return CompanyFactory::new();
    }
}
