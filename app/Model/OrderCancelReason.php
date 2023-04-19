<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderCancelReason extends Model
{
    protected $fillable = ['order_id', 'type', 'user_id', 'partner_id', 'reason_heading', 'details'];
}
