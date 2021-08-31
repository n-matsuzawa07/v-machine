<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App/Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'company_id' => $faker->randomNumber(2),
        'product_name' => $faker->word,
        'price' => $faker->numberBetween(100, 195),
        'stock' => $faker->randomNumber(2),
        'comment' => $faker->realText()
    ];
});