<?php

namespace App\Jobs;

use App\Models\Feed;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;

class DiscoverFeeds implements ShouldQueue
{
    use Dispatchable;

    use InteractsWithQueue;

    use Queueable;

    use SerializesModels;

    private string $link;

    public function __construct(array|string|bool|null $link)
    {
        $this->link = $link;
    }

    public function handle(): void
    {

        Log::info('Processing of feed discovery for started.' . $this->link);

        $process = new Process(
            [
            'python3',
            base_path('python/feed-finder.py'),
            $this->link,
            ]
        );

        $process->run(
            function ($type, $buffer) {

                dd($buffer);

                if (strlen($buffer) > 10) {

                    Log::info("Output: $buffer");

                    Log::error("Output: $buffer");

                    $feed = Feed::where('url', $buffer)->first();

                    if ($feed === null) {
                        $feed = Feed::create(
                            [
                            'url' => $this->link,
                            ]
                        );
                    }

                }
            }
        );
    }
}
