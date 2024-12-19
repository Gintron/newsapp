<?php

namespace App\Dto;

class News 
{
    public function __construct(
        public readonly string $title,
        public readonly int $category_id,
        public readonly string $source,
    ) {}

    public function toArray(): array
    {
        return [
            "title" => $this->title,
            "category_id" => $this->category_id,
            "source" => $this->source,
        ];
    }
}