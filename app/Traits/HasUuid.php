<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasUuid
{
    /**
     * Define a uuid when the model is created.
     */
    public static function bootHasUuid()
    {
        static::creating(function($model) {
            $model->uuid = Str::uuid();
        });
    }
}
