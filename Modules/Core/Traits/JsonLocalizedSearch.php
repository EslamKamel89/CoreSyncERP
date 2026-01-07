<?php

namespace Modules\Core\Traits;

trait JsonLocalizedSearch {
    public function scopeSearchLocalizedJson(
        $query,
        string $column,
        string $search
    ) {
        $locales = array_keys(config('core.locales.availableLocales'));
        return $query->where(function ($q) use ($column, $search, $locales) {
            foreach ($locales as $locale) {
                $q->orWhere("{$column}->{$locale}", 'LIKE', "%{$search}%");
            }
        });
    }
}
