<?php

namespace App\Http\Controllers\Api;

use App\Bookable;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class BookablePriceController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($id, Request $request)
    {
        $bookable = Bookable::findOrFail($id);
        
        $data = $request->validate([
            'from' => 'required|date_format:Y-m-d',
            'to' => 'required|date_format:Y-m-d|after_or_equal:from',
        ]);

        $days = (new Carbon($data['from']))->diffInDays(new Carbon($data['to']));
        $totalPrice = $days * $bookable->price;

        return response()->json([
            'total' => $totalPrice,
            'breakdown' => [
                $bookable->price => $days //We return the price for each specific day. Atm in our app we have the same price for every day but in the future we could build a price breakdown depending on the days booked. (Holidays? Special days?...)
            ]
        ]);
    }
}
