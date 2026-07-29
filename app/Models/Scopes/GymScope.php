<?php

namespace App\Models\Scopes;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class GymScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $hasUserAuth = Auth::check();
        $userAuth = Auth::user();
        if ($hasUserAuth && $userAuth->role->name !== config('gym.rol_super_admin')) {
            $builder->where('gym_id', $userAuth->gym_id);
        }
    }
}
