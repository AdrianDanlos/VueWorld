<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Booking extends Model
{
    protected $fillable = ['from', 'to']; //This is to allow the mass asignment we have done in BookingsTableSeeder line30

    public function bookable()
    {
        return $this->belongsTo(Bookable::class);
    }

    public function scopeBetweenDates(Builder $query, $from, $to)
    {
        return $query->where('to', '>', $from)
            ->where('from', '<', $to);
    }
}
