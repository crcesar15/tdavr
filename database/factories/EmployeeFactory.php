<?php

use Faker\Generator as Faker;

$factory->define(App\Employee::class, function (Faker $faker) {
    return [
        'profession' => $faker->jobTitle,
        'email' => $faker->unique()->email,
        'phone' => $faker->phoneNumber,
    ];
});
