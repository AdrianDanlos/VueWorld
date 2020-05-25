<?php

namespace App;

use Illuminate\Support\Carbon;
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

    public function pricefor($from, $to): array
    {
        $days = (new Carbon($from))->diffInDays(new Carbon($to));
        $price = $days * $this->price;

        return [
            'total' => $price,
            'breakdown' => [
                $this->price => $days //We return the price for each specific day. Atm in our app we have the same price for every day but in the future we could build a price breakdown depending on the days booked. (Holidays? Special days?...)
            ]
        ];
    }
}
