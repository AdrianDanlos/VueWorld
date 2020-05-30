<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookableByCountryReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    //We should ALWAYS return from the database ONLY the information we are going to use. 
    //As we are only going to use created_at, rating and content from the review object we can customize it here. This way calling::all() will only return these 3 fields.
    //This is way cleaner than specifying the columns we want to retrieve in the query each time we call the database.
    public function toArray($request)
    {
        return [
            'rating' => $this->rating,
        ];
    }
}
