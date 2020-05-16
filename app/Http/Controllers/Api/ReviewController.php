<?php

namespace App\Http\Controllers\Api;

use App\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReviewResource;

class ReviewController extends Controller
{
    public function show($id){
        return new ReviewResource(Review::findOrFail($id));  //ReviewResource object retrieves only the created_data column to check if the review exists
    }
}
