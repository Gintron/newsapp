<?php

use App\Services\News;
use Illuminate\Support\Facades\Route;

Route::get('/', function (News $news) {
    dd($news->getNewsPage(1));
    return view('welcome');
});
