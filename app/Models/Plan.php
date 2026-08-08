<?php

namespace App\Models;

use App\Models\Concerns\BelongsToGym;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use BelongsToGym, SoftDeletes;
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
