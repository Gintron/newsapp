<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use App\Repositories\NewsCacheRepository;
use Illuminate\Http\Request;

class UserFeedController extends Controller
{
    public function __construct(
        private readonly NewsCacheRepository $newsCacheRepository
    ) {}

    /**
     * Retrieve the personalized news feed for the authenticated user.
     *
     * @OA\Get(
     *     path="/api/user/feed",
     *     tags={"News"},
     *     summary="Retrieve the personalized news feed for the authenticated user",
     *     description="Fetch a personalized news feed based on the user's preferences (sources and categories), with pagination support.",
     *     security={{
     *         "bearerAuth": {}
     *     }},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         required=false,
     *         description="The page number to fetch. Defaults to 1.",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response with the personalized news feed.",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="title", type="string", example="Breaking News: Local Event"),
     *                 @OA\Property(property="content", type="string", example="Details about the event..."),
     *                 @OA\Property(property="category_id", type="integer", example=3),
     *                 @OA\Property(property="source", type="string", example="guardian"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-12-20T14:00:00Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized, no valid authentication token provided.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unauthorized")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No news found for the given user and preferences.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="No news found!")
     *         )
     *     )
     * )
     */
    public function __invoke(Request $request)
    {
        $page = (int) $request->get('page', 1);

        $user = $request->user();
        $news = $this->newsCacheRepository->getUserFeed($user->id, $page, $user->preferences);

        return response()->json($news);
    }
}
