<?php

namespace App\Services\Providers;

use App\Dto\News;
use App\Models\SourceCategory;
use Illuminate\Database\Eloquent\Collection;
use jcobhams\NewsApi\NewsApi;

class NewsApiProvider implements NewsProviderInterface
{
    public function getNews(int $numberOfNews): array
    {
        $sourceCategories = $this->getCategories();

        $newsapi = new NewsApi(config("parameters.newsapi_api_key"));

        $responses = [];
        foreach ($sourceCategories as $sourceCategory) {
            $responses[$sourceCategory->category->id] = $newsapi->getTopHeadlines(null, null, null, $sourceCategory->category_name, $numberOfNews);
        }

        $news = [];
        foreach ($responses as $key => $response) {
            foreach ($response->articles as $article) {
                $news[] = new News($article->title, $key, "newsapi");
            }
        }
        return $news;
    }

    public function getCategories(): Collection
    {
        return SourceCategory::with("category")->where("source", "newsapi")->get();
    }
}
