<?php

use Faker\Generator as Faker;

$factory->define(App\Lesson::class, function (Faker $faker) {
    $titulo = $faker->sentence;
    return [
        'course_id' 	=> \App\Course::all()->random()->id,
        'titulo' 		=> $titulo,
        'descripcion' 	=> $faker->paragraph,
        'link_video' 	=> $faker->url,
        'slug' 			=> str_slug($titulo, '-')
    ];
});
