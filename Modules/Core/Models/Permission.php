<?php

namespace Modules\Core\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Core\Traits\BuildsListData;

class Permission extends SpatiePermission {
    use BuildsListData;
    protected $fillable = [
        'name',
        'guard_name',

        // White-label
        'external_id',
        'meta',
        'status',
    ];
    protected $casts = [
        'meta' => 'array',
    ];
}
