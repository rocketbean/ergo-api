<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\JobRequestItem;
use Faker\Generator as Faker;

$factory->define(JobRequestItem::class, function (Faker $faker) {
    return [
        'name'        => $faker->words(3, true),
        'description' => $faker->sentence,
    ];
});
