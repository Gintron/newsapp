<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use App\Models\News as ModelsNews;
use App\Services\News;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(Request $request, News $newsService)
    {
        $search = $request->get('search');
        $date = $request->get('date');
        $category = (int) $request->get('category');
        $source = $request->get('source');
        $page = (int) $request->get('page', 1);

        if ($search && ($date || $category || $source)) {
            $news = ModelsNews::search($search)->get();
            if ($category) {
                $news = $news->where("category_id", $category);
            }
            if ($source) {
                $news = $news->where("source", $source);
            }
            if ($date) {
                $news = $news->filter(function ($item) use ($date) {
                    return Carbon::parse($item->created_at)->toDateString() === $date;
                });
            }
        } else if (!$search && ($date || $category || $source)) {
            $news = ModelsNews::query();
    
            if ($category) {
                $news = $news->where("category_id", $category);
            }
            if ($source) {
                $news = $news->where("source", $source);
            }
            if ($date) {
                $news = $news->whereDate("created_at", $date);
            }
    
            $news = $news->get();
        } else if ($search) {
            return response()->json(ModelsNews::search($search)->paginate(10));
        } else {
            $page = (int) $request->get("page", 1);
            $news = $newsService->getNewsPage($page);
        }
    
        return response()->json($news);
    }
}
