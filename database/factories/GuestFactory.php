<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use App\Guest;
use Faker\Generator as Faker;

$factory->define(Guest::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'field_id' => $faker->numberBetween($min = 1, $max = 10000),
        'guest_name' => $faker->name,
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
        'address' => $faker->address, 
        'city' => $faker->city, 
        'zip' => $faker->postcode,
        'country' => $faker->country, 
        'note' => $faker->text(20)
    ];
});
