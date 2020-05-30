<?php

namespace App\Http\Controllers\Api;


use App\Bookable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Resources\BookableByCountryResource;
use App\Http\Resources\BookableByCountryReviewResource;
use App\Review;

class BookableCountryController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($country, Request $request)
    {
        return BookableByCountryResource::collection(Bookable::where('country', $country)->get());
    }
}
