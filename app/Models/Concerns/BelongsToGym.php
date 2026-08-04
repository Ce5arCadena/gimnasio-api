<?php

namespace App\Models\Concerns;

use App\Models\Scopes\GymScope;

trait BelongsToGym
{
    /**
     * The "bootBelongsToGym" method of the model.
     */
    protected static function bootBelongsToGym(): void
    {
        static::addGlobalScope(new GymScope);

        static::creating(function ($model) {
            if (auth()->check() && !$model->gym_id) {
                $model->gym_id = auth()->user()->gym_id;
            }
        });
    }
}
