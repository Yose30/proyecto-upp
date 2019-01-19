<?php

use Faker\Generator as Faker;

$factory->define(App\Goal::class, function (Faker $faker) {
    return [
        'student_id'	=> \App\Student::all()->random()->id,
        'meta' 			=> $faker->sentence
    ];
});
