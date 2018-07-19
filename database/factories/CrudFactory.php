<?php

use Faker\Generator as Faker;

$factory->define(App\Crud::class, function (Faker $faker) {
    return [
        'name' => $faker->lexify('????????'),
        'color' =>$faker->boolean ? 'red' : 'green'
    ];
});
