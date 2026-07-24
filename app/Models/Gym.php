<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gym extends Model
{
    protected $fillable = [
        "name",
        "address",
        "photo",
        "owner_name"
    ];

    public function users() {
        return $this->hasMany(User::class);
    }

    public function members() {
        return $this->hasMany(Member::class);
    }

    public function plans() {
        return $this->hasMany(Plan::class);
    }

    public function memberships() {
        return $this->hasMany(Membership::class);
    }
}
