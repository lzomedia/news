<?php

namespace App\Jobs;

use App\Models\Feed;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class DiscoverFeeds implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Collection $links;

    public function __construct(Collection $links)
    {
        $this->links = $links;
    }

    public function handle(): void
    {
        $this->links->each(function ($link) {

            $feed = Feed::where('url', $link)->first();

            if (is_null($feed))
            {
               Feed::create([
                    'url' => $link,
                ]);
            }
        });
    }
}
