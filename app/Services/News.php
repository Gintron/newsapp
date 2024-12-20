<?php

namespace App\Services;

use App\Models\News as ModelNews;
use App\Repositories\NewsCacheRepository;
use App\Services\Providers\GuardianProvider;
use App\Services\Providers\NewsApiProvider;
use App\Services\Providers\NewsProviderInterface;
use App\Services\Providers\NewYorkTimesProvider;

class News
{
    public function __construct(
        private readonly NewsApiProvider $newsApiProvider,
        private readonly GuardianProvider $guardianProvider,
        private readonly NewYorkTimesProvider $newYorkTimesProvider,
        private readonly NewsCacheRepository $newsCacheRepository,
    ) {}

    private function getNewsFromProvider(NewsProviderInterface $newsProvider, int $numberOfNews)
    {
        return $newsProvider->getNews($numberOfNews);
    }

    private function getNews()
    {
        $guardianNews = $this->getNewsFromProvider($this->guardianProvider, 10);
        $newsApiNews =  $this->getNewsFromProvider($this->newsApiProvider, 10);
        $newYorkTimes = $this->getNewsFromProvider($this->newYorkTimesProvider, 10);

        return array_merge($guardianNews, $newsApiNews, $newYorkTimes);
    }

    public function storeNews(): void
    {
        $news = array_map(fn($newsDto) => $newsDto->toArray(), $this->getNews());

        ModelNews::insert($news);
    }

    public function getNewsPage(int $page = 1)
    {
        return $this->newsCacheRepository->getPage($page);
    }
}
