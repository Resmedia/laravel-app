<?php

use App\News;
use Faker\Generator;

$factory->define(News::class, function (Generator $faker) {
    return [
        'title' => $faker->sentence(5),
        'content' => $faker->text(1000),
        'author_id' => rand(0, 10)
    ];
});
