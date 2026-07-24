<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'membership_id',
        'amount',
        'paid_at'
    ];

    protected function casts() {
        return [
            'paid_at' => 'date'
        ];
    }

    public function membership() {
        return $this->belongsTo(Membership::class);
    }
}
