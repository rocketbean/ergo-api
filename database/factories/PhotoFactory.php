<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Photo;
use Faker\Generator as Faker;

$factory->define(Photo::class, function (Faker $faker) {
    return [
        'data' => $faker->imageUrl,
    ];
});
