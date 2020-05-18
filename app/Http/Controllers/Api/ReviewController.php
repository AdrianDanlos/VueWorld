<?php

namespace App\Http\Controllers\Api;

use App\Review;
use App\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReviewResource;

class ReviewController extends Controller
{
    public function show($id)
    {
        return new ReviewResource(Review::findOrFail($id)); //ReviewResource object retrieves only the created_data column to check if the review exists
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|size:36|unique:reviews',
            'content' => 'required|min:2',
            'rating' => 'required|in:1,2,3,4,5'
        ]);

        $booking = Booking::findByReviewKey($data['id']);

        //Booking has already been reviewed. To avoid multiple windows on the browser to make multiple reviews
        if (null === $booking) {
            return abort(404);
        }

        //We remove the uuid from the booking object. This way we know it has already been reviewed.
        //(info) The booking object is initially created with an UUID. Whenever it's review is posted the UUID is removed from the booking object and given to the new review object.
        $booking->review_key = '';
        $booking->save();

        $review = Review::make($data); //massive/automatic assignment thanks to the fillable method specified on the review model. We create the object with the array coming on the request.
        $review->booking_id = $booking->id; //Security, user could have changed it on the client
        $review->bookable_id = $booking->bookable_id; //Security, user could have changed it on the client
        $review->save();

        return new ReviewResource($review);
    }
}
