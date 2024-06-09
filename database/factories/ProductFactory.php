<?php

// database/factories/ProductFactory.php
namespace Database\Factories;
use App\Models\Product;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'category_id' => \App\Models\Category::factory(),
            'brand' => $this->faker->word,
               'description' => $this->faker->sentence,
        ];
    }
}
