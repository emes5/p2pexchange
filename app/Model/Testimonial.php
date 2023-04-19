<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = ['name','designation', 'messages', 'image', 'status', 'company_name','unique_code'];

    public function getImageAttribute($photo) {
        $p = asset('assets/img/avater.png');
        if(!empty($photo)) {
            $p =  asset(path_image().$photo);
        }
        return $p;
    }
}
