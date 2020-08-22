<?php

/**
 * @var \Illuminate\Database\Eloquent\Factory $factory
 */

use App\Book;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(
    Book::class,
    function (Faker $faker) {
        $factory_image_name = Carbon::now()->format('YmdHisu') . "_1.jpg";
        copy("/home/david/Desktop/Bookcovers/bc" . random_int(1, 10) . ".jpg", storage_path() . '/app/uploads/' . $factory_image_name  );
        return [
        'isbn' => $faker->isbn13,
        'title' => $faker->sentence(4),
        'author' => $faker->name,
        'price' => $faker->numberBetween(1, 500000),
        'stock' => $faker->numberBetween(1, 1000),
        'image_path' => "/uploads/" . $factory_image_name,
        'is_active' => true
        ];
    }
);
