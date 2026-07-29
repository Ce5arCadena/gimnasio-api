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
    }
}
