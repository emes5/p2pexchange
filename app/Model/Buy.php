<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Buy extends Model
{
    protected $fillable = ['user_id', 'coin_type', 'wallet_id', 'country', 'address', 'currency', 'ip', 'coin_rate', 'rate_percentage', 'market_price', 'rate_type',
        'price_type', 'minimum_trade_size', 'maximum_trade_size', 'headline', 'terms', 'instruction', 'status','unique_code', 'coin_id'];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public static function payment($buy_id)
    {
        return OfferPaymentMethod::where(['offer_id' => $buy_id, 'offer_type' => BUY])->get();
    }
}
