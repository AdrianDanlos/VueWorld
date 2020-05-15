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

    //This is used to customize the data from an object we get from the api or database. Most of the time there is data that we won't be using, thus it doesn't make sense to retrieve it. (Example, update or create timestpams...)
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
