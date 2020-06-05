<?php

namespace App\Http\Controllers\Api;

use App\Bookable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookableReviewIndexResource;

class BookableReviewController extends Controller
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

        $reviews = BookableReviewIndexResource::collection($bookable->reviews()->latest()->get());
        $reviewsLength = count($reviews);

        //Get faces and usernames from public api
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', "https://randomuser.me/api/?inc=name,picture&results={$reviewsLength}");
        $users = json_decode($response->getBody())->results;

        foreach($reviews as $key=>$review){
           $review->name = $users[$key]->name;
           $review->picture = $users[$key]->picture;
        }

        return $reviews;
    }
}
