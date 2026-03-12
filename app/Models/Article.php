<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'content',
        'slug',
        'status',
        'published_at',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'article_category');
    }

    // Generación de Slug Automático
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($article) {
            $article->slug = \Illuminate\Support\Str::slug($article->title) . '-' . uniqid();
        });
    }
}
