<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Escrow extends Model
{
    protected $fillable = ['user_id', 'wallet_id', 'order_id', 'amount', 'fees', 'type', 'status', 'fees_percentage'];
}
