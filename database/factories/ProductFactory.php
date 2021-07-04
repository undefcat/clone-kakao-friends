<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'price' => $this->faker->numberBetween(),
            'stock' => $this->faker->numberBetween(),
            'name' => $this->faker->name,
            'content' => $this->faker->paragraph,
        ];
    }
}
