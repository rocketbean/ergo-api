<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\JobRequest;
use Faker\Generator as Faker;

$factory->define(JobRequest::class, function (Faker $faker) {
    return [
        'name'        => $faker->words(3, true),
        'description' => $faker->sentence,
        'status_id'   => 2
    ];
});
