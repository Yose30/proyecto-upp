<?php

use Faker\Generator as Faker;

$factory->define(App\Answer::class, function (Faker $faker) {
    return [
        'question_id' => \App\Question::all()->random()->id,
        'answer' => $faker->sentence,
        'type' => \App\Result::INCORRECTO 
    ];
});
