<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Review;
use Illuminate\Support\Str;
use Faker\Generator as Faker;


$ratingTendency = random_int(3, 4);
$lowestRating = 1;
$weighter = mt_rand(1, 3);
$weighterResult = $weighter == 2 || $weighter == 3;

if ($ratingTendency == 4 && $weighterResult) { //66% of $lowestRating == 4;
    $lowestRating == 4;
} else {
    $lowestRating == $ratingTendency - 1;
}

$factory->define(Review::class, function (Faker $faker) use($ratingTendency, $lowestRating){
    return [
        'id' => Str::uuid(),
        'content' => $faker->sentences(5, true),
        'rating' => random_int($lowestRating, $ratingTendency + 1)
    ];
});
