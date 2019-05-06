<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Location;
use Faker\Generator as Faker;

$factory->define(Location::class, function (Faker $faker) {
    return [
      'address1' => $faker->streetName,
      'address2' => $faker->streetAddress,
      'city'     => $faker->city,
      'state'    => $faker->postcode,
      'country'  => $faker->country,
      'lat'      => $faker->latitude,
      'lng'      => $faker->longitude,
    ];
});
