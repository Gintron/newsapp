<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Repositories\NewsCacheRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __construct(
        private readonly NewsCacheRepository $newsCacheRepository
    ) {}

    /**
     * Retrieve a list of news articles with optional filters.
     *
     * @OA\Get(
     *     path="/api/news",
     *     tags={"News"},
     *     summary="Retrieve news articles",
     *     description="Get a paginated list of news articles with optional filters such as search, date, category, and source.",
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         required=false,
     *         description="Search term for the news title or content.",
     *         @OA\Schema(type="string", example="general")
     *     ),
     *     @OA\Parameter(
     *         name="date",
     *         in="query",
     *         required=false,
     *         description="Filter news by a specific date in YYYY-MM-DD format.",
     *         @OA\Schema(type="string", format="date", example="2024-12-20")
     *     ),
     *     @OA\Parameter(
     *         name="category",
     *         in="query",
     *         required=false,
     *         description="Filter news by category ID.",
     *         @OA\Schema(type="integer", example=3)
     *     ),
     *     @OA\Parameter(
     *         name="source",
     *         in="query",
     *         required=false,
     *         description="Filter news by source name (e.g., guardian, newsapi, new_york_times).",
     *         @OA\Schema(type="string", example="guardian")
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         required=false,
     *         description="Specify the page number for pagination.",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response with a list of news articles.",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="title", type="string", example="Breaking News: general Advances"),
     *                 @OA\Property(property="content", type="string", example="Details about the news article..."),
     *                 @OA\Property(property="category_id", type="integer", example=3),
     *                 @OA\Property(property="source", type="string", example="guardian"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-12-20T14:00:00Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request due to invalid parameters.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Invalid parameters provided.")
     *         )
     *     )
     * )
     */
    public function __invoke(Request $request)
    {
        $search = $request->get('search');
        $date = $request->get('date');
        $category = (int) $request->get('category');
        $source = $request->get('source');
        $page = (int) $request->get('page', 1);

        if ($search && ($date || $category || $source)) {
            $news = News::search($search)->get();
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
            $news = $this->newsCacheRepository->getFilteredNews($page, $date, $category, $source);
        } else if ($search) {
            return response()->json(News::search($search)->paginate(10));
        } else {
            $page = (int) $request->get("page", 1);
            $news = $this->newsCacheRepository->getPage($page);
        }
    
        return response()->json($news);
    }
}
