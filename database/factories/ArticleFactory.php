<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Article>
 */
class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition(): array
    {
        $title = fake()->sentence(4);
        return [
            'title'      => $title,
            'content'    => fake()->paragraphs(3, true),
            'slug'       => Str::slug($title) . '-' . uniqid(),
            'status'     => fake()->randomElement(['borrador', 'publicado']),
            'user_id'    => User::factory(),
        ];
    }
}
