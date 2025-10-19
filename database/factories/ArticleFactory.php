<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/** @extends Factory<Article> */
class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition(): array
    {
        return [
            'author_id' => User::factory(),
            'title' => $this->faker->word(),
            'content' => $this->faker->word(),
        ];
    }

    public function published(Carbon $date): ArticleFactory
    {
        return $this->state(fn (array $attributes) => [
            'published_at' => $date,
        ]);
    }
}
