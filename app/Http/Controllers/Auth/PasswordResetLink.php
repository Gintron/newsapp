<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class PasswordResetLink 
{
        /**
     * Send a password reset link to the user's email.
     *
     * @OA\Post(
     *     path="/api/password/reset-link",
     *     tags={"Authentication"},
     *     summary="Request a password reset link",
     *     description="Send a password reset link to the email address provided.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"email"},
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Reset link sent successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="We have emailed your password reset link!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Failed to send reset link",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unable to send reset link to the provided email.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="The email field is required."),
     *             @OA\Property(property="errors", type="object", 
     *                 @OA\Property(property="email", type="array", 
     *                     @OA\Items(type="string", example="The email must be a valid email address.")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function __invoke(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));
    
        return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => __($status)], 200)
            : response()->json(['message' => __($status)], 400);
    }
}