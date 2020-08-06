<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Ticket;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Ticket::class, function (Faker $faker) {
    // return [
    //     'name' => $faker->name,
    //     'email' => $faker->unique()->safeEmail,
    //     'email_verified_at' => now(),
    //     'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
    //     'remember_token' => Str::random(10),
    // ];

    return [
        'title' => $faker->realText(45),
        'description' => $faker->realText(100),
        'submitter_id' => $faker->numberBetween(1, 50),
        'priority_id' => $faker->randomElement([1, 2, 3]),
        'status_id' => $faker->randomElement([1, 2, 3, 4]),
        'category_id' => $faker->randomElement([1, 2, 3, 4]),
        'project_id' => $faker->numberBetween(1, 50),
        'developer_id' => $faker->numberBetween(1, 50)
    ];
});
