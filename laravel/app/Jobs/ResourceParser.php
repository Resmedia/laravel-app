<?php

namespace App\Jobs;

use App\Services\XMLParseService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ResourceParser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $link;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($link)
    {
        $this->link = $link;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(XMLParseService $parseService)
    {
        $parseService->saveNews($this->link);
    }
}
