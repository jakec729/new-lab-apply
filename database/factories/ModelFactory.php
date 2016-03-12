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
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Movie::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'year' => $faker->year,
        'watched' => "X"
    ];
});

$factory->define(App\Comment::class, function (Faker\Generator $faker) {
    return [
        'movie_id' => $faker->name,
        'user_id' => $faker->name,
        'body' => $faker->paragraph
    ];
});

$factory->define(App\Application::class, function (Faker\Generator $faker) {
    return [
        'submitted_on' => $faker->date,
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'company' => $faker->company,
        'website' => $faker->url,
        'link_1' => $faker->url,
        'link_2' => $faker->url,
        'desks' => $faker->randomElement(['Solo: 1 Person', 'Micro: 2-4', 'Medium: 10-30']),
        'discipline' => $faker->randomElement(['Robotics', 'Urban Tech', 'Nano Tech', 'Life Sciences', 'Additive Manufacturing', 'Energy']),
        'membership_type' => $faker->randomElement(['Resident', 'Flex', 'Urban Tech']),
        'text_pitch' => $faker->paragraph,
        'text_tech' => $faker->paragraph,
        'text_team' => $faker->paragraph,
        'text_strategy' => $faker->paragraph,
        'funding_stage' => $faker->randomElement(['Bootstrap', 'Grants', 'Venture Funding']),
        'new_lab_resources' => comma_separate($faker->randomElements(['Prototyping Shops', 'Event Space', 'Member Community'], 2)),
        'text_community' => $faker->paragraph
    ];
});

