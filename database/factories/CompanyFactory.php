<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Company;
use Faker\Generator as Faker;

$factory->define(Company::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'country' => $faker->country,
        'type' => $faker->randomElement(['Tech', 'Finance', 'Health', 'Retail', 'Education']),
        'importance' => $faker->numberBetween(1, 10)
    ];
});
