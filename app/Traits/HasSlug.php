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
            $model->slug = Str::slug($model->{$model->slugSource});
        });
    }
}
