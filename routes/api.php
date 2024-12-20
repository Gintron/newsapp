<?php

use App\Http\Controllers\Account\GetPreferencesController;
use App\Http\Controllers\Account\SetPreferencesController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\PasswordResetLink;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\News\IndexController;
use App\Http\Controllers\News\ShowController;
use App\Http\Controllers\News\UserFeedController;
use Illuminate\Support\Facades\Route;

Route::post("/register", RegisterController::class);
Route::post("/login", LoginController::class);
Route::post("/logout", LogoutController::class);
Route::post("/password/reset-link", PasswordResetLink::class)->name("password.email");
Route::post("/password/reset", ResetPasswordController::class)->name("password.update");

Route::get("/news", IndexController::class);
Route::get("/news/{id}", ShowController::class);

Route::middleware('auth:sanctum')->get('/user/preferences', GetPreferencesController::class);
Route::middleware('auth:sanctum')->post('/user/preferences', SetPreferencesController::class);

Route::middleware('auth:sanctum')->get('/my-feed', UserFeedController::class);