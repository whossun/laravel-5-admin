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

$factory->define(App\User::class, function ($faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => str_random(10),
        'remember_token' => str_random(10),
    ];
});


$factory->define(App\Article::class, function ($faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->sentence(10),
        'content' => $faker->text(200),
        'author' => $faker->randomDigit,
    ];
});


$factory->define(App\Permission::class, function ($faker) {
    return [
        'name' => $faker->name,
        'label' => $faker->sentence(1),
    ];
});
