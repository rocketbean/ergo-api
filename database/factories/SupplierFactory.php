<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Supplier;
use Faker\Generator as Faker;

$factory->define(Supplier::class, function (Faker $faker) {
    return [
      'name'        => $faker->name,
      'description' => $faker->sentence,
    ];
});
