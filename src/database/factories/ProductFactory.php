<?php

namespace Danial\SimpleMarketplace\database\factories;

use App\Models\User;
use Danial\SimpleMarketplace\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->words(3, true),
            'price' => $this->faker->numberBetween(1500, 6000),
            'delivery_price' => $this->faker->numberBetween(0, 200),
            'user_id' => User::factory()->create()->id,
        ];
    }
}
