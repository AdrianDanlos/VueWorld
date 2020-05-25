<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Booking extends Model
{
    protected $fillable = ['from', 'to']; //This is to allow the mass asignment we have done in BookingsTableSeeder line30

    public function bookable()
    {
        return $this->belongsTo(Bookable::class);
    }

    public function review(){
        return $this->hasOne(Review::class);
    }

    public function address(){
        return $this->belongsTo(Address::class);
    }

    public function scopeBetweenDates(Builder $query, $from, $to)
    {
        return $query->where('to', '>', $from)
            ->where('from', '<', $to);
    }

    public static function findByReviewKey(string $reviewKey): ?Booking{
        //->with('bookable'). It uses the bookable_id column (fk) to retrieve the bookable object and retrieve it inside the booking object.
        //This is great since we only have to create a single query to retrieve the bookable object related to de booking.
        return static::where('review_key', $reviewKey)->with('bookable')->get()->first();
    }


    //Using Laravel Model Events
    //This method initializes how an eloquent model should behave. This method is define in the parent class, Model.
    protected static function boot(){
        //parent:: refers to the Model. Booking extends from model (inheritance)
        parent::boot();

        //static:: refers to the current class
        //We are calling "creating" method which is a Laravel model event. Whenever a new booking is created we implement some logic.
        static::creating(function($booking){
            $booking->review_key = Str::uuid(); //Whenever a new booking is created we automatically assign a review key to it.
        });
    }
}
