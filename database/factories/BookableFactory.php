<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Bookable;
use Illuminate\Support\Arr;
use Faker\Generator as Faker;


$suffix = [ 'Villa', 'House', 'Cottage', 'Luxury Villas', 'Cheap House', 'Rooms', 'Cheap Rooms', 'Luxury Rooms', 'Fancy Rooms'];

//Fill array with images URLs
$directory = '/home/vagrant/code/AirBnB/public/images/house_images';
$images = glob("$directory/*.{jpg,jpeg,png,gif}", GLOB_BRACE);
$startOfUrl = strpos( $images[0], "/images" );

//Reformat the URL to be correctly displayed
$images_formatted_url = array_map(function($image) use($startOfUrl){
    return substr( $image, $startOfUrl, strlen($image) );
}, $images);
 

$factory->define(Bookable::class, function (Faker $faker) use($suffix, $images_formatted_url) {
    return [
        'title' => $faker->city . ' ' . Arr::random($suffix),
        'description' => $faker->text(),
        'photo_url' => $images_formatted_url[array_rand($images_formatted_url)],
        'price' => random_int(15, 250)
    ];
});
