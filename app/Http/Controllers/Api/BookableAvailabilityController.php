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

        return $bookable->availableFor($data['from'], $data['to'])
            ? response()->json([])
            : response()->json([], 404); //No availability found for these dates. When calling this function from the frontend we will get back either a 200 response or a 404. We are customizing the response of the server.
    }
}
