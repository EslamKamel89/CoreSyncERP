<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Modules\Core\Database\Factories\TagFactory;

class Tag extends Model {
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        "company_id",
        "name",
        "slug",
        "external_id",
        "meta",
        "status",
        "created_by",

    ];
    protected $casts  = [
        'meta' => 'array'
    ];


    protected static function newFactory(): TagFactory {
        return TagFactory::new();
    }
    public function taggables(): MorphToMany {
        return $this->morphedByMany(Model::class, 'taggable');
    }
}
