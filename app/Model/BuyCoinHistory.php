<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class BuyCoinHistory extends Model
{
    protected $fillable = [
        'confirmations',
        'status',
        'coin_id',
        'coin_type',
        'coin',
        'phase_id',
        'bonus_percentage',
        'fees',
        'btc',
        'doller',
        'bonus',
        'requested_amount',
        'transaction_id',
        'address',
        'type',
        'admin_confirmation',
        'bank_sleep',
        'bank_id',
    ];

    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
}
