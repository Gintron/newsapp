<?php

use App\Http\Controllers\News\IndexController;
use App\Http\Controllers\News\ShowController;
use Illuminate\Support\Facades\Route;

Route::get("/", IndexController::class);

Route::get("news/{id}", ShowController::class);