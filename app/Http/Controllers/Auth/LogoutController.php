<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

class LogoutController
{
    /**
     * Logout the authenticated user.
     *
     * @OA\Post(
     *     path="/api/logout",
     *     tags={"Authentication"},
     *     summary="User logout",
     *     description="Revoke the authenticated user's current access token.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Logout successful",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Logged out successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unauthenticated")
     *         )
     *     )
     * )
     */

    public function __invoke(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}