<?php

namespace App\Jobs;

use App\Contracts\FeedContract;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessDomains implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private FeedContract $feedContract;

    public function __construct(FeedContract $feedContract)
    {
        $this->feedContract = $feedContract;
    }


    public function handle(): void
    {
    }
}
