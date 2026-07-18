<?php

namespace App\Traits;

use Illuminate\Support\Str;

/**
 * Trait HasUuid.
 */
trait HasSlug
{
    public static function bootHasSlug()
    {
        static::saving(function ($model) {
            $baseSlug = Str::slug($model->{$model->slugSource});
            $slug = $baseSlug;
            $suffix = 2;

            while (
                $model::where('slug', $slug)
                    ->when($model->exists, fn ($query) => $query->whereKeyNot($model->getKey()))
                    ->exists()
            ) {
                $slug = "{$baseSlug}-{$suffix}";
                $suffix++;
            }

            $model->slug = $slug;
        });
    }
}
