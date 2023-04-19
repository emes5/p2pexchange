<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = ['sender_id', 'receiver_id', 'message', 'file', 'order_id', 'status', 'seen'];

    public function sender_user()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver_user()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
