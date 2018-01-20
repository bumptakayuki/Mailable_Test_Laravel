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

$factory->define(App\Post::class, function ($faker) {
    return [
        'title' => $faker->sentence,
        'content' => $faker->paragraphs(3, true),
        'created_at' => $faker->dateTimeThisYear($max = 'now', $timezone = date_default_timezone_get()),
        'updated_at' => $faker->dateTimeThisYear($max = 'now', $timezone = date_default_timezone_get()),
        // 'user_id' => function () {
        //     return factory(App\User::class)->create()->id;
        // }
    ];
});