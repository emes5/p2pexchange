<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CountryPaymentMethod extends Model
{
    protected $fillable = ['payment_method_id', 'country'];
}
