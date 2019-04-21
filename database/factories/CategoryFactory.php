<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(\App\Category::class, function (Faker $faker) {
    $name = $faker->word . $faker->randomNumber(5);

    return [
        'name' => $name,
        'slug' => Str::slug($name),
    ];
});
