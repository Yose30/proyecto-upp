<?php

use Faker\Generator as Faker;

$factory->define(App\Course::class, function (Faker $faker) {
    $nombre = $faker->sentence;
    //$completo = $faker->randomElement([0,1]);
    $estado = $faker->randomElement([\App\Course::PUBLICADO, \App\Course::PENDIENTE]);
    return [
        // 'administrator_id'    => \App\Administrator::all()->random()->id,
        // 'teacher_id' 	=> \App\Teacher::all()->random()->id,
        // 'level_id' 		=> \App\Level::all()->random()->id,
        'nombre' 		=> $nombre,
        'descripcion' 	=> $faker->paragraph,
        'objetivo' 		=> $faker->sentence,
        'slug' 			=> str_slug($nombre, '-'),
        'imagen' 		=> 'imagen.jpg',
        'estado' 		=> \App\Course::PUBLICADO
    ];
});
