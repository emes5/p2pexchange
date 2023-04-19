<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PaymentWindow extends Model
{
    protected $fillable = [
        'payment_time',
        'status'
    ];
}
