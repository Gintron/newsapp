<?php

namespace App\Jobs;

use App\Services\News;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class GetNewsJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
    ) {}

    /**
     * Execute the job.
     */
    public function handle(News $newsService): void
    {
        $newsService->storeNews();
    }
}