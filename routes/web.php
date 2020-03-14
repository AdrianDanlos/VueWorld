<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//If the input is a link starting with anything but 'api' return the main view.
Route::get('/{any?}', function () {
    return view('welcome');
})->where('any', '^(?!api\/)[\/\w\.-]*');
