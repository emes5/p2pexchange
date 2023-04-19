<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'buyer_id',
        'seller_id',
        'buyer_wallet_id',
        'seller_wallet_id',
        'sell_id',
        'buy_id',
        'coin_type',
        'currency',
        'rate',
        'amount',
        'price',
        'fees',
        'status',
        'payment_status',
        'type',
        'payment_id',
        'payment_sleep',
        'transaction_id',
        'fees_percentage',
        'order_id',
        'is_reported',
        'unique_code',
        'buyer_feedback',
        'seller_feedback',
        'payment_time',
        'payment_expired_time',
        'admin_note'
    ];

    public function seller()
    {
        return $this->belongsTo(User::class,'seller_id');
    }

    public function buyer()
    {
        return $this->belongsTo(User::class,'buyer_id');
    }

    public function buy_data()
    {
        return $this->belongsTo(Buy::class, 'buy_id');
    }
    public function sell_data()
    {
        return $this->belongsTo(Sell::class, 'sell_id');
    }

    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class,'payment_id');
    }
}
