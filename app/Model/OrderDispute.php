<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class OrderDispute extends Model
{
    protected $fillable = ['order_id', 'user_id', 'reported_user', 'reason_heading', 'details', 'status', 'updated_by','image', 'type','unique_code'];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function reporting_user()
    {
        return $this->belongsTo(User::class,'reported_user');
    }

}
