<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Coin extends Model
{
    protected $fillable = [
        'name',
        'type',
        'status',
        'is_withdrawal',
        'is_deposit',
        'is_buy',
        'is_sell',
        'unique_code',
        'image',
        'details',
        'minimum_withdrawal',
        'maximum_withdrawal',
        'minimum_trade_size',
        'maximum_trade_size',
        'withdrawal_fees',
        'trade_fees',
        'escrow_fees',
        'max_withdrawal_per_day',
    ];
}
