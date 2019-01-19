<?php

use Faker\Generator as Faker;

$factory->define(App\Question::class, function (Faker $faker) {
    return [
    	'lesson_id' =>	\App\Lesson::all()->random()->id,
        'question' 	=> 	$faker->sentence
    ];
});
