<?php

namespace App\Repositories;

use App\Models\News;
use Illuminate\Support\Facades\Cache;

class NewsCacheRepository
{
    public function getPage(int $page = 1)
    {
        $news = Cache::get("news_page_$page");

        if ($news === null) {
            $offset = 0;
            if ($page > 1) {
                $offset = $page * 10 - 10;
            }

            $news = News::orderBy('created_at', 'desc')->offset($offset)->paginate(10);
            Cache::put("news_page_$page", $news, now()->addHours(8));
        }
        return $news;
    }

    public function getSingleNews(int $id): ?News
    {
        $news = Cache::get("news_$id");

        if (!$news) {
            $news = News::find($id);
           
            if(!$news) return null;
            
            $news = Cache::rememberForever("news_$id", function () use ($news) {
                return $news;
            });
        }
        return $news;
    }
}
