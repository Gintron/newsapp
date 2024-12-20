<?php

namespace App\Services\Providers;

use App\Dto\News;
use App\Enums\NewsSource;
use App\Models\SourceCategory;
use Illuminate\Database\Eloquent\Collection;

class NewYorkTimesProvider implements NewsProviderInterface
{
    public function getNews(int $numberOfNews): array
    {
        $sourceCategories = $this->getCategories();
       
        $responses = [];
        foreach ($sourceCategories as $sourceCategory) {
            $responses[$sourceCategory->category->id] = $this->getNewsForCategory($sourceCategory->category_name, $numberOfNews);
        }

        $news = [];
        foreach ($responses as $key => $category) {
            foreach ($category["response"]["docs"] as $article) {
                $news[] = new News($article["headline"]["main"], $key, NewsSource::NEW_YORK_TIMES, now(), now());
            }
        }
        return $news;
    }

    public function getCategories(): Collection
    {
        return SourceCategory::with("category")->where("source", NewsSource::NEW_YORK_TIMES)->get();
    }

    private function getNewsForCategory(string $category, int $numberOfNews)
    {
        $apiKey = config("parameters.newyorktimes_api_key");

        $url = "https://api.nytimes.com/svc/search/v2/articlesearch.json?facet_fields=section_name&limit=$numberOfNews&facet_filter=true&q=$category&api-key=$apiKey";

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $response = curl_exec($ch);
        
        if (curl_errno($ch)) {
            echo "cURL Error: " . curl_error($ch);
            curl_close($ch);
            exit;
        }

        curl_close($ch);

        return json_decode($response, true);
    }
}
