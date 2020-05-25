<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookableIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    //This is used to format or customize the object we are retrieving from the api or database (serializing). Most of the time the object will have fields that are not useful in our logic. (Example, update or create timestpams...)
    //It's also very useful to customize objects depending on the user. For example, for admins it could be very useful to have all the object data but for regular users we want to keep some data hidden.
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'photo_url' => $this->photo_url
        ];
    }
}
