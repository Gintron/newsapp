<?php

namespace App\Repositories;

use App\Models\News;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

class NewsCacheRepository
{
    public function getPage(int $page = 1)
    {
        $news = Cache::get("news_page_$page");

        if (!$news) {
            $offset = $this->getOffset($page);

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

            if (!$news) return null;

            $news = Cache::rememberForever("news_$id", function () use ($news) {
                return $news;
            });
        }
        return $news;
    }

    public function getUserFeed(int $id, int $page, array $preferences)
    {
        $userNews = Cache::get("user_feed_$id" . "_" . "$page");

        if (!$userNews) {
            $offset = $this->getOffset($page);

            $userNews = News::whereIn("source", $preferences["sources"])
                ->whereHas("category", function (Builder $query) use ($preferences) {
                    $query->whereIn("slug", $preferences["categories"]);
                })
                ->offset($offset)
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            Cache::put("user_feed_$id" . "_" . "$page", $userNews, now()->addHours(8));
        }
        return $userNews;
    }

    public function getFilteredNews(int $page, ?string $date, ?int $category, ?string $source)
    {
        $filteredNews = Cache::get("filtered_news_$page" . "_$date" . "_$category" . "_$source");

        if (!$filteredNews) {
            $news = News::query();

            if ($category) {
                $news = $news->where("category_id", $category);
            }
            if ($source) {
                $news = $news->where("source", $source);
            }
            if ($date) {
                $news = $news->whereDate("created_at", $date);
            }
            $offset = $this->getOffset($page);
            $filteredNews = $news->offset($offset)->paginate(10);
            Cache::remember("filtered_news_$page" . "_$date" . "_$category" . "_$source", now()->addHours(8), function () use ($filteredNews) {
                return $filteredNews;
            });
        }
        return $filteredNews;
    }

    private function getOffset(int $page): int
    {
        if ($page > 1) {
            return $page * 10 - 10;
        }
        return 0;
    }
}
