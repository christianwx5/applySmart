<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\JobPriority;
use Faker\Generator as Faker;

$factory->define(JobPriority::class, function (Faker $faker) {
    
    // protected $model = JobPriority::class;
    
    return [
        'name' => $this->faker->word, 
        'description' => $this->faker->sentence, 
        'value' => $this->faker->numberBetween(100, 1000)
    ];
});
