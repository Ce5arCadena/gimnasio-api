<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    protected $fillable = [
        'gym_id',
        'member_id',
        'plan_id',
        'start_date',
        'end_date',
        'total_amount'
    ];

    protected function casts() {
        return [
            'start_date' => 'date',
            'end_date' => 'date'
        ];
    }

    public function gym() {
        return $this->belongsTo(Gym::class);
    }

    public function member() {
        return $this->belongsTo(Member::class);
    }

    public function plan() {
        return $this->belongsTo(Plan::class);
    }

    public function payments() {
        return $this->hasMany(Payment::class);
    }
}
