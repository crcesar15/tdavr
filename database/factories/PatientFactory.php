<?php

use Faker\Generator as Faker;

$factory->define(App\Patient::class, function (Faker $faker) {
    return [
        'date_of_birth' => $faker->dateTimeBetween($startDate = '-15 years', $endDate = '-7year'),
        'contact_number' => $faker->phoneNumber,
        'responsible_name' => $faker->firstName . " " . $faker->lastName
    ];
});
