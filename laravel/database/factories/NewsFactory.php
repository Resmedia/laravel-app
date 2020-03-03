<?php

use App\News;
use App\User;
use Faker\Generator;

$factory->define(News::class, function (Generator $faker) {
    return [
        'title' => $faker->sentence,
        'content' => $faker->text(500),
        'posted_at' => now(),
        'author_id' => function () {
            return factory(User::class)->create()->id;
        }
    ];
});
