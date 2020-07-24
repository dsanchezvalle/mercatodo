<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Book;
use Faker\Generator as Faker;

$factory->define(Book::class, function (Faker $faker) {
    return [
        'isbn' => $faker->isbn13,
        'title' => $faker->sentence(4),
        'author' => $faker->name,
        'price' => $faker->numberBetween(1,100000),
        'stock' => $faker->numberBetween(1,200),
        'image_path' => $faker->imageUrl(400,350),
        'is_active' => true
    ];
});
