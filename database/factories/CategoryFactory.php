<?php
declare(strict_types=1);

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Category;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Category::class, function (Faker $faker) {
    return [
        Category::ATTR_NAME => $name = $faker->unique()->name,
        Category::ATTR_SLUG => Str::slug($name),
        Category::ATTR_PARENT_ID => null,
    ];
});
