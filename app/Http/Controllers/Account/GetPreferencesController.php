<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;

class GetPreferencesController
{
    /**
     * Retrieve the user's preferences.
     *
     * @OA\Get(
     *     path="/api/user/preferences",
     *     tags={"Preferences"},
     *     summary="Get user preferences",
     *     description="Retrieve the currently set preferences for the authenticated user.",
     *     @OA\Response(
     *         response=200,
     *         description="User preferences retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="preferences",
     *                 type="object",
     *                 example={
     *                     "sources": {"guardian", "newsapi"},
     *                     "categories": {"general", "sport"}
     *                 },
     *                 description="The user's currently set preferences."
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     ),
     *     security={
     *         {"sanctum": {}}
     *     }
     * )
     */
    public function __invoke(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'preferences' => $user->preferences ?? []
        ]);
    }
} 