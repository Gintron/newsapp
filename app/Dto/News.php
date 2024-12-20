<?php

namespace App\Dto;

use App\Enums\NewsSource;
use Carbon\Carbon;

class News 
{
    public function __construct(
        public readonly string $title,
        public readonly int $category_id,
        public readonly NewsSource $source,
        public readonly Carbon $created_at,
        public readonly Carbon $updated_at,
    ) {}

    public function toArray(): array
    {
        return [
            "title" => $this->title,
            "category_id" => $this->category_id,
            "source" => $this->source,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}