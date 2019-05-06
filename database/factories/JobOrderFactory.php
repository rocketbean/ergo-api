<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\JobOrder;
use Faker\Generator as Faker;

$factory->define(JobOrder::class, function (Faker $faker) {
    return [
        'remarks' => $faker->sentence,
        'status_id' => 2
    ];
});
