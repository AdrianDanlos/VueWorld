<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bookable extends Model
{
    public function bookings(){
        return $this->hasMany(Booking::class); //Booking::class === 'App\Booking'
    }

    public function reviews(){
        return $this->hasMany(Review::class);
    }

    public function availableFor($from, $to): bool
    {
        //We check in the database if the dates are available using an Eloquent Query Scope that we created on the Booking model. 
        //It's basically a METHOD (betweenDates) to create a custom query. https://laravel.com/docs/7.x/eloquent#local-scopes
        //The query to the database returns the amount of bookings that are being overlapped for these dates. If it returns 0, the apartment is free.
        return 0 === $this->bookings()->betweenDates($from, $to)->count();
    }
}
