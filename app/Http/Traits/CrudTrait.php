<?php

namespace App\Http\Traits;

use Illuminate\Support\Str;

trait CrudTrait
{
    public static function boot()
    {
        parent::boot();
        static::creating(function($model){
            $model->uuid = Str::uuid();
            $model->created_by = auth()->id() ?? null;
        });
        self::updating(function($model){
            $model->updated_by = auth()->id() ?? null;
        });

        self::deleting(function($model){
            $model->deleted_by = auth()->id() ?? null;
        });
    }
}
