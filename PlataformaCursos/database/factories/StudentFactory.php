<?php

use Faker\Generator as Faker;

$factory->define(App\Student::class, function (Faker $faker) {
    $cuatrimestre = $faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9]);
    $carrera = $faker->randomElement(['Ingeniería en financiera', 'Ingeniería en biomédica', 'Ingeniería en biotecnología', 'Ingeniería en mecatrónica', 'Ingeniería en mecánica automotriz', 'Ingeniería en software', 'Ingeniería en telemática']);

    return [
        'user_id' => null,
        'cuatrimestre' => $cuatrimestre,
        'carrera' => $carrera,
        'domicilio' => $faker->address,
        'telefono' => $faker->phoneNumber,
    ];
}); 
