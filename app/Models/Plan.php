<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'gym_id',
        'name',
        'duration_days',
        'price'
    ];

    public function gym() {
        return $this->belongsTo(Gym::class);
    }

    public function memberships() {
        return $this->hasMany(Membership::class);
    }
}
