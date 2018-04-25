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

/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'username' => $faker->userName,
        'email' => $faker->unique()->safeEmail,
        'email_confirmed' => $faker->dateTime,
        'lock' => 0,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(60),
    ];
});

$factory->define(App\Models\Permission::class, function (Faker\Generator $faker) {
    return [

    ];
});

$factory->define(App\Models\Role::class, function (Faker\Generator $faker) {
    return [

    ];
});

$factory->define(App\Models\Network::class, function (Faker\Generator $faker) {
    return [
        
    ];
});
