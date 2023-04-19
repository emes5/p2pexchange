<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OfferPaymentMethod extends Model
{
    protected $fillable = ['offer_id', 'payment_method_id', 'offer_type'];

    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }
}
