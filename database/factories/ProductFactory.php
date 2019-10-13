<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Product::class, function (Faker $faker) {
    return [
        Product::ATTR_TITLE => $title = $faker->unique()->sentence(4),
        Product::ATTR_SLUG => Str::slug($title),
        Product::ATTR_DESCRIPTION => $faker->text,
        Product::ATTR_IMAGE_URL => $faker->imageUrl(),
    ];
});
