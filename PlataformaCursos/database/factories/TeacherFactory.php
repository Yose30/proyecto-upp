<?php

use Faker\Generator as Faker;

$factory->define(App\Teacher::class, function (Faker $faker) {
    return [
        'user_id' 	=> null,
        'profesion' => $faker->jobTitle,
        'biografia' => $faker->paragraph,
    ];
});
