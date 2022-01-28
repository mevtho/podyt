<?php

namespace App\Traits;

use Ramsey\Uuid\Uuid;

/**
 * Trait HasUuid.
 */
trait HasUuid
{
    public static function bootHasUuid()
    {
        static::saving(function ($model) {
            if (!$model->uuid) {
                $model->uuid = Uuid::uuid4();
            }
        });
    }
}
