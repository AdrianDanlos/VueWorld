<?php

namespace App\Http\Controllers\Api;

use App\Bookable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookableAvailabilityController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    //This is a Laravel single action controller. It does only performs one task and can be called like a function.
    public function __invoke($id, Request $request)
    {
        //get input dates from the request and validate them with the validate method
        //this validation should probably be client side.
        $data = $request->validate([
            'from' => 'required|date_format:Y-m-d|after_or_equal:now',
            'to' => 'required|date_format:Y-m-d|after_or_equal:from',
        ]);

        $bookable = Bookable::findOrFail($id);

        //$bookable->bookings vs $bookable->bookings()
        //On the first one we fetch the bookings of that bookable (Relation established on the model) 
        //On the second one we start to create a query to filter some of the results

        //We check in the database if the dates are available using an Eloquent Query Scope that we created on the Booking model. 
        //It's basically a custom query method (betweenDates) that we have created on our Booking model. https://laravel.com/docs/7.x/eloquent#local-scopes
        //The query to the database returns the amount of bookings that are being overlapped for these dates. If it returns 0, the apartment is free.
        dd($bookable->bookings()->betweenDates($data['from'], $data['to'])->count());
    }
}
