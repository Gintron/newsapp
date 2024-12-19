<?php

namespace App\Services\Providers;

use Illuminate\Database\Eloquent\Collection;

interface NewsProviderInterface 
{
    public function getNews(int $numberOfNews): array;

    public function getCategories(): Collection;
}