<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountryList extends Model
{
    protected $fillable = [
        'key',
        'value',
        'status'
    ];
}
