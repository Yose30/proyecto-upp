<?php

use Faker\Generator as Faker;

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

$factory->define(App\User::class, function (Faker $faker) {
    $name = $faker->name;
    $lastName = $faker->lastName;
    return [
    	'role_id' 	=> null,
        'name' 		=> $name,
        'lastName' 	=> $lastName,
        'email' 	=> $faker->unique()->safeEmail,
        'clave' 	=> $faker->unique()->randomNumber($nbDigits = NULL, $strict = false),
        'password' 	=> bcrypt('secret'),
        'view_password' => 'secret',
        'slug' 		=> str_slug($name." ".$lastName, "-"),
        'remember_token' => str_random(10),

    ];
});
