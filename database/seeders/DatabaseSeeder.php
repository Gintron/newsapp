<?php

namespace Database\Seeders;

use App\Enums\NewsSource;
use App\Models\Category;
use App\Models\SourceCategory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Category::insert([
            ['name' => 'Health', 'slug' => 'health', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sport',  'slug' => 'sport', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'General', 'slug' => 'general', 'created_at' => now(), 'updated_at' => now()],
        ]);


        SourceCategory::insert(
            [
                [
                    "category_name" => "health",
                    "source" => NewsSource::NEWSAPI,
                    "category_id" => Category::where("slug", "health")->first()->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    "category_name" => "sports",
                    "source" => NewsSource::NEWSAPI,
                    "category_id" => Category::where("slug", "sport")->first()->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    "category_name" => "general",
                    "source" => NewsSource::NEWSAPI,
                    "category_id" => Category::where("slug", "general")->first()->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    "category_name" => "healthcare-network",
                    "source" => NewsSource::GUARDIAN,
                    "category_id" => Category::where("slug", "health")->first()->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    "category_name" => "sport",
                    "source" => NewsSource::GUARDIAN,
                    "category_id" => Category::where("slug", "sport")->first()->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    "category_name" => "world",
                    "source" => NewsSource::GUARDIAN,
                    "category_id" => Category::where("slug", "general")->first()->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    "category_name" => "Health",
                    "source" => NewsSource::NEW_YORK_TIMES,
                    "category_id" => Category::where("slug", "health")->first()->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    "category_name" => "Sports",
                    "source" => NewsSource::NEW_YORK_TIMES,
                    "category_id" => Category::where("slug", "sport")->first()->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    "category_name" => "News",
                    "source" => NewsSource::NEW_YORK_TIMES,
                    "category_id" => Category::where("slug", "general")->first()->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]
        );
    }
}
