<?php

namespace App\Http\Controllers\Api;

use App\Address;
use App\Booking;
use App\Bookable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CheckoutController extends Controller
{
    public function __invoke(Request $request)
    {
        $data = $request->validate([
            //Laravel docs array validation
            'bookings' => 'required|array|min:1',
            'bookings.*.bookable_id' => 'required|exists:bookables,id',
            'bookings.*.from' => 'required|date|after_or_equal:today',
            'bookings.*.to' => 'required|date|after_or_equal:bookings.*.from', //use tomorrow instead
            'customer.first_names' => 'required|min:2',
            'customer.last_name' => 'required|min:2',
            'customer.street' => 'required|min:3',
            'customer.city' => 'required|min:2',
            'customer.email' => 'required|email',
            'customer.country' => 'required|min:2',
            'customer.state' => 'required|min:2',
            'customer.zip' => 'required|min:2'
        ]);
        $data = array_merge($data, $request->validate([
            'bookings.*' => ['required', function ($attribute, $value, $fail) { //Laravel docs validation closure
                $bookable = Bookable::findOrFail($value['bookable_id']);

                if (!$bookable->availableFor($value['from'], $value['to'])) {
                    $fail("The object is not available in given dates!");
                }
            }]
        ]));

        $bookingsData = $data['bookings'];
        $addressData = $data['customer'];

        $bookings = collect($bookingsData)->map(function ($bookingData) use ($addressData) {
            $bookable = Bookable::findOrFail($bookingData['bookable_id']);
            $booking = new Booking();
            $booking->from = $bookingData['from'];
            $booking->to = $bookingData['to'];
            $booking->price = $bookable->priceFor($booking->from, $booking->to)['total'];
            $booking->bookable()->associate($bookable); // The associate syntax is the same as $booking->bookable_id = $bookable->id; (associate only works for belongs to relathionships)
            $booking->address()->associate(Address::create($addressData));

            $booking->save();

            return $booking;
        });

        //Return the review keys
        $reviewKeys = [];
        foreach($bookings as $booking){
            array_push($reviewKeys, $booking->review_key);
        } 
        return $reviewKeys;
    }
}
