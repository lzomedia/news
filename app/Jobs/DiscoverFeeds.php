<?php

namespace App\Jobs;

use App\Models\Feed;
use Carbon\Carbon;
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

        $process = new Process([
            'python3',
            base_path('python/feed-finder.py'),
            $this->link
        ]);

        $process->run(
            function ($type, $buffer) {
                if (strlen($buffer) > 10) {
                    $data = json_decode($buffer, true);
                    if(is_array($data)) {
                        $this->save($data);
                    }

                }
            }
        );
    }

    private function save(array $data): void
    {
        foreach ($data as $feed) {
            $title = parse_url($feed, PHP_URL_HOST);
            $exists = Feed::where('url', $feed)->exists();
            if (!$exists) {
                Feed::create([
                    'title' => $title,
                    'url' => $feed,
                    'status' => Feed::INITIAL,
                    'sync' => Carbon::now()
                ]);
            }
        }
    }


    public function failed(): void
    {
        $this->delete();
    }
}
