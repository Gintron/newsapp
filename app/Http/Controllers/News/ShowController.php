<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use App\Repositories\NewsCacheRepository;

class ShowController extends Controller
{
    public function __construct(
        private readonly NewsCacheRepository $newsCacheRepository
    ) {}

    /**
     * Retrieve a single news article by its ID.
     *
     * @OA\Get(
     *     path="/api/news/{id}",
     *     tags={"News"},
     *     summary="Retrieve a single news article",
     *     description="Fetch a specific news article using its unique ID from the cache.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="The ID of the news article to retrieve.",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response with the news article.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="title", type="string", example="Breaking News: Local Event"),
     *             @OA\Property(property="content", type="string", example="Details about the event..."),
     *             @OA\Property(property="category_id", type="integer", example=3),
     *             @OA\Property(property="source", type="string", example="guardian"),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2024-12-20T14:00:00Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="News not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="News not found!")
     *         )
     *     )
     * )
     */
    public function __invoke(int $id) 
    {
        $news = $this->newsCacheRepository->getSingleNews($id);

        if (!$news) {
            response()->json("News not found!");
        }

        return response()->json($news);
    }
}
