<?php

namespace App\Http\Controllers\Api;

use App\Bookable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookableShowResource;
use App\Http\Resources\BookableIndexResource;

class BookableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return BookableIndexResource::collection(Bookable::all()); //On this one we call the collection method because Bookable::all() is returning a collection of objects.
    }

 
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new BookableShowResource(Bookable::findOrFail($id)); //On this one we create a resource object and pass our bookable to it's constructor because Bookable::findOrFail($id) is returning a single object.
    }

}
