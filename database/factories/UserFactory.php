<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use Illuminate\Support\Str;
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

$factory->define(User::class, function (Faker $faker) {
    $first_name = $faker->firstName;
    $last_name  = $faker->lastName;

    $random = random_int(1, 3);
    $location = $random === 1 ? random_int(1, 2) : null;
    $type = random_int(1, 2) < 2 ? 'cloudcom' : 'guestquest';

    return [
        'first_name'      => $first_name,
        'last_name'       => $last_name,
        'role_id'         => random_int(2, 3),
        'organization_id' => $type === 'cloudcom' ? 4 : $random,
        'location_id'     => $type === 'cloudcom' ? null : $location,
        'full_name'       => $first_name . ' ' . $last_name,
        'email'           => $faker->unique()->safeEmail,
        'password'        => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'avatar'          => 'https://api.adorable.io/avatars/285/' . $faker->unique()->safeEmail . '.png',
        'remember_token'  => null,
        'created_at'      => $faker->dateTimeBetween('-7 days', 'now', 'Asia/Manila')
    ];
});
