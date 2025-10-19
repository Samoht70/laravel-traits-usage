<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/** @extends Factory<Product> */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'creator_id' => User::factory(),
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'price' => $this->faker->word(),
            'stock' => $this->faker->randomNumber(),
        ];
    }

    public function published(Carbon $date): ProductFactory
    {
        return $this->state(fn (array $attributes) => [
            'released_at' => $date,
        ]);
    }
}
