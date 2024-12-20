<?php

namespace App\Http\Controllers\Account;

use App\Enums\NewsSource;
use App\Models\Category;
use App\Services\Account\PreferenceService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class SetPreferencesController
{
    public function __construct(
        private readonly PreferenceService $preferenceService
    ) {}

        /**
     * Set user preferences for news sources and categories.
     *
     * @OA\Post(
     *     path="/api/user/preferences",
     *     tags={"Preferences"},
     *     summary="Set user preferences",
     *     description="Allows users to set their news preferences, including news sources and categories.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"preferences"},
     *             @OA\Property(
     *                 property="preferences",
     *                 type="object",
     *                 @OA\Property(
     *                     property="sources",
     *                     type="array",
     *                     @OA\Items(type="string", example="guardian"),
     *                     description="Array of selected news sources."
     *                 ),
     *                 @OA\Property(
     *                     property="categories",
     *                     type="array",
     *                     @OA\Items(type="string", example="sport"),
     *                     description="Array of selected news categories."
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Preferences updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Preferences updated successfully!"),
     *             @OA\Property(
     *                 property="preferences",
     *                 type="object",
     *                 @OA\Property(
     *                     property="sources",
     *                     type="array",
     *                     @OA\Items(type="string", example="guardian")
     *                 ),
     *                 @OA\Property(
     *                     property="categories",
     *                     type="array",
     *                     @OA\Items(type="string", example="sport")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Validation failed"),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(property="preferences", type="array",
     *                     @OA\Items(type="string", example="The preferences field is required.")
     *                 ),
     *                 @OA\Property(property="preferences.sources", type="array",
     *                     @OA\Items(type="string", example="Valid options are: guardian, newsapi, new_york_times")
     *                 ),
     *                 @OA\Property(property="preferences.categories", type="array",
     *                     @OA\Items(type="string", example="Valid options are: general, sports, health")
     *                 )
     *             )
     *         )
     *     ),
     *     security={
     *         {"sanctum": {}}
     *     }
     * )
     */
    public function __invoke(Request $request)
    {
        try {
            $categories = Category::pluck("slug")->all();
            $request->validate([
                'preferences' => ["required", "array"],
                'preferences.sources' => ["array"],
                'preferences.sources.*' => ["required", Rule::in(NewsSource::values())],
                'preferences.categories' => ["array"],
                'preferences.categories.*' => Rule::in($categories),
            ], [
                'preferences.required' => 'You must select at least one news source.',
                'preferences.array' => 'The preferences field must be an array.',
                'preferences.sources.*.in' => 'Valid options are: ' . implode(", ", NewsSource::values()),
                'preferences.categories.*.in' => 'Valid options are: ' . implode(", ", $categories),
            ]);

            $user = $request->user();
            $this->preferenceService->setPreferences($user, $request->get("preferences"));
            
            return response()->json([
                'message' => 'Preferences updated successfully!',
                'preferences' => $user->preferences,
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        }
    }
}
