<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookableByCountryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'photo_url' => $this->photo_url,
            'price' => $this->price,
            'country' => $this->country,
            'city' => $this->city,
            'country_code' => $this->country_code,
            'country_flag' => $this->country_flag,
            'reviews' => BookableByCountryReviewResource::collection($this->reviews),
        ];
    }
}
