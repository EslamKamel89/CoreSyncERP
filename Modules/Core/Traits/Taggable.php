<?php

namespace Modules\Core\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Modules\Core\Models\Tag;

trait Taggable {
    public function tags(): MorphToMany {
        return $this->morphToMany(Tag::class, 'taggable')
            ->withTimestamps();
    }

    public function attachTag(Tag|int|String $tag) {
        $tagId = $this->resolveTagId($tag);
        $this->tags()->syncWithoutDetaching([$tag]);
    }

    public function detachTag(Tag|int|String $tag) {
        $tagId = $this->resolveTagId($tag);
        $this->tags()->detach($tagId);
    }
    public function syncTags(array $tags) {
        $ids = collect($tags)
            ->map(fn($tag) => $this->resolveTagId($tag))
            ->values()
            ->toArray();
        $this->tags()->sync($ids);
    }
    public function scopeWithTag(Builder $query, string $tag): Builder {
        return $query->whereHas('tags', function ($q) use ($tag) {
            $q->where('name', $tag)->orWhere('slug', $tag);
        });
    }
    public function scopeWithoutTag(Builder $query, string $tag) {
        return $query->whereDoesntHave('tags', function ($q) use ($tag) {
            $q->where('name', $tag)->orWhere('slug', $tag);
        });
    }
    protected function resolveTagId(Tag|int|String $tag): int {
        if ($tag instanceof Tag) {
            return $tag->id;
        }
        if (is_int($tag)) {
            return $tag;
        }
        return Tag::where('slug', $tag)
            ->orWhere('name', $tag)
            ->value('id');
    }
}
