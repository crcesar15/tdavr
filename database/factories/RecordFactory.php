<?php

use Faker\Generator as Faker;

$factory->define(App\Record::class, function (Faker $faker) {
    return [
        'successes' => $faker->numberBetween(0,50),
        'mistakes' => $faker->numberBetween(0,50),
        'false_positive_rate' => $faker->numberBetween(0,50),
        'time' => $faker->randomFloat('2',0, 150)
    ];
});
