<?php

namespace App\Repositories;

use App\Models\Article;

class ArticleRepository
{
    public function getAll()
    {
        return Article::with('categories', 'user')->latest()->get();
    }

    public function getById($id)
    {
        return Article::with('categories', 'user')->findOrFail($id);
    }

    public function create(array $data, array $categoryIds = []): Article
    {
        $article = Article::create($data);
        $article->categories()->sync($categoryIds);
        return $article->load('categories');
    }

    public function update(int $id, array $data, array $categoryIds = []): Article
    {
        $article = Article::findOrFail($id);
        $article->update($data);
        $article->categories()->sync($categoryIds);
        return $article->load('categories');
    }

    public function delete(int $id): void
    {
        $article = Article::findOrFail($id);
        $article->delete();
    }
}
