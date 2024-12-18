<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\JobOffer;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(JobOffer::class, function (Faker $faker) {
    return [
        'title' => $faker->jobTitle,
        'description' => $faker->sentence,
        'createdAt' => now(),
        'Company' => $faker->company,
        'idApplyStatus' => $faker->numberBetween(1, 10),
        'idPriority' => $faker->numberBetween(1, 2)
    ];
});

