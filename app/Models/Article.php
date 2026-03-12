<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'title',
        'content',
        'status',
        'published_at',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'article_category');
    }
}
