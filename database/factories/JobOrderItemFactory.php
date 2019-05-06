<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\JobOrderItem;
use Faker\Generator as Faker;

$factory->define(JobOrderItem::class, function (Faker $faker) {
    return [
        'remarks' => $faker->sentence,
        'amount' => $faker->randomFloat(2)
    ];
});
