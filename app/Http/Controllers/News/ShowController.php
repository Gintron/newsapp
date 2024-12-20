<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use App\Repositories\NewsCacheRepository;

class ShowController extends Controller
{
    public function __construct(
        private readonly NewsCacheRepository $newsCacheRepository
    ) {}

    public function __invoke(int $id) 
    {
        $news = $this->newsCacheRepository->getSingleNews($id);

        if (!$news) {
            response()->json("News not found!");
        }

        return response()->json($news);
    }
}
