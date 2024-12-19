<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\SourceCategory;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
                    "source" => "newsapi",
                    "category_id" => Category::where("slug", "health")->first()->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    "category_name" => "sports",
                    "source" => "newsapi",
                    "category_id" => Category::where("slug", "sport")->first()->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    "category_name" => "general",
                    "source" => "newsapi",
                    "category_id" => Category::where("slug", "general")->first()->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    "category_name" => "healthcare-network",
                    "source" => "guardian",
                    "category_id" => Category::where("slug", "health")->first()->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    "category_name" => "sport",
                    "source" => "guardian",
                    "category_id" => Category::where("slug", "sport")->first()->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    "category_name" => "world",
                    "source" => "guardian",
                    "category_id" => Category::where("slug", "general")->first()->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    "category_name" => "Health",
                    "source" => "new_york_times",
                    "category_id" => Category::where("slug", "health")->first()->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    "category_name" => "Sports",
                    "source" => "new_york_times",
                    "category_id" => Category::where("slug", "sport")->first()->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    "category_name" => "News",
                    "source" => "new_york_times",
                    "category_id" => Category::where("slug", "general")->first()->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]
        );
    }
}
