<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Log;

trait Loggable
{
    public static function bootLoggable()
    {
        static::created(function ($model) {
            Log::info('Created: ' . get_class($model) . ' ID: ' . $model->id);
        });

        static::updated(function ($model) {
            Log::info('Updated: ' . get_class($model) . ' ID: ' . $model->id);
        });

        static::deleted(function ($model) {
            Log::info('Deleted: ' . get_class($model) . ' ID: ' . $model->id);
        });
    }
}
