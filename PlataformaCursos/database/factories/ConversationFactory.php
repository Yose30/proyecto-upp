<?php

use Faker\Generator as Faker;
use App\Conversation;

$factory->define(Conversation::class, function (Faker $faker) {
    return [
        'teacher_id'	=> 1,
        'user_id'	=> 24,
    ];
});
