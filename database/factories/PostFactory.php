<?php

use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(\App\Post::class, function (Faker $faker) {
    $title = $faker->sentence(6, 1);
    $slug = Str::slug($title);

    return [
        'slug'      => $slug,
        'title'     => $title,
        'author_id' => rand(1, 4),
        'content'   => $faker->text(1500),
        'published' => rand(0, 1),
        'comments_enabled' => rand(0, 1),
    ];
});
