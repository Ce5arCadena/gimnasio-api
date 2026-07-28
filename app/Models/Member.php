<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Member extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'gym_id',
        'name',
        'phone',
        'join_date',
        'initial_weight'
    ];

    protected function casts()
    {
        return [
            'join_date' => 'date'
        ];
    }

    protected function status(): Attribute
    {
        return Attribute::make(
            get: function () {
                $lastMembership = $this->memberships()->latest('end_date')->first();

                if (!$lastMembership) {
                    return 'no_membership';
                }

                return $lastMembership->end_date->gte(today())
                    ? 'active'
                    : 'expired';
            }
        );
    }

    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }

    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }
}
