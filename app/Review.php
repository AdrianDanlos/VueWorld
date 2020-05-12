<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    
    public function bookable(){
        return $this->belongsTo(Bookable::class);
    }

    public function booking(){
        return $this->belongsTo(Booking::class);
    }

    //We need those 2 functions to specify that we are not using an incrementing id in our migration but an uuid instead (which is a string).
    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }
}
