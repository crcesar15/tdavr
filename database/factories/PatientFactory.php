<?php

use Faker\Generator as Faker;

$factory->define(App\Patient::class, function (Faker $faker) {
    return [
        'date_of_birth' => $faker->date('Y-m-d', '2015-01-01'),
        'contact_number' => $faker->phoneNumber,
        'responsible_name' => $faker->firstName . " " . $faker->lastName
    ];
});
