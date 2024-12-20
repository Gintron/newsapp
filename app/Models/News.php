<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Scout\Searchable;

class News extends Model
{
    use Searchable;
    
    protected $fillable = [
        "title",
        "category_id",
        "source"
    ];

    public function searchableAs(): string
    {
        return 'news_index';
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
