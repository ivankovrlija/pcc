<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use App\Field;
use Faker\Generator as Faker;

$factory->define(Field::class, function (Faker $faker) {
    return [
        'field_name' => $faker->text(2020)
    ];
});
