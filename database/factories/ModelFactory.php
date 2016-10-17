<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\CalenderEntry::class, function (Faker\Generator $faker) {
    return [
        'start' => $faker->dateTimeBetween('01.01.2016', '31.12.2016'),
        'finish' => $faker->dateTimeBetween('01.01.2016', '31.12.2016'),
        'subject' => $faker->word,
        'color' => $faker->hexColor,
        'params' => '',
        'deleted_at' => null,
    ];
});
