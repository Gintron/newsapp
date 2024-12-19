<?php

namespace App\Repositories;

use App\Models\News;
use Illuminate\Support\Facades\Cache;

class NewsCacheRepository
{
    public function getPage(int $page)
    {
        $value = Cache::rememberForever("test", function () {
            return "test";
        });
        dump($value);
        $news = Cache::get("test");
        dump($news);
        if ($news === null) {
            $offset = 0;
            if ($page > 1) {
                $offset = $page * 10 - 10;
            }
            
            $news = News::orderBy('created_at', 'desc')->offset($offset)->paginate(10);
            //Cache::tags(['news_pages'])->put("news_page_$page", "test", now()->addHours(8));
            Cache::remember("test", now()->addHours(8), function () use ($news) {
                return "test";
            });
        }
        return $news;
    }
}
