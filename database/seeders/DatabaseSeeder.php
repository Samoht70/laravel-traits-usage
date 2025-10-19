<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Comment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory()
            ->count(10)
            ->has(Article::factory()->published(Carbon::now())->count(3), 'articles')
            ->has(Article::factory()->count(2), 'articles')
            ->has(Product::factory()->published(Carbon::now())->count(3), 'products')
            ->has(Product::factory()->count(2), 'products')
            ->create();

        $articles = Article::query()->with('author')->get();
        $products = Product::query()->with('creator')->get();

        foreach ($users as $user) {
            foreach ($articles as $article) {
                Comment::factory()->for($user)->for($article, 'commentable')->createOne();
            }

            foreach ($products as $product) {
                Comment::factory()->for($user)->for($product, 'commentable')->createOne();
            }
        }
    }
}
