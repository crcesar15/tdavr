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
    $firstName = $faker->firstName;
    $lastName = $faker->lastName;
    return [
        'first_name' => $firstName,
        'last_name' => $lastName,
        'profile_photo' => \Faker\Provider\Image::image(storage_path() . '/app/public/profile_photos', 400, 400, 'people', false),
        'username' => $firstName . '.' . $lastName,
        'password' => bcrypt('123456'), // 123456
        'remember_token' => str_random(10)
    ];
});
