<?php

namespace App\DTO;

use App\Jobs\DiscoverFeeds;
use App\Models\Category;
use App\Models\Feed;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\DataTransferObject\Attributes\MapFrom;
use Spatie\DataTransferObject\DataTransferObject;
use Symfony\Component\DomCrawler\Crawler;

class FeedFinder extends DataTransferObject
{
    #[MapFrom('feedInfos')]
    public ?array $feeds;

    #[MapFrom('relatedTopics')]
    public ?array $topics;

    public function getFeeds(): array
    {

        $content = collect([]);

        foreach ($this->feeds as $feed)
        {
            $prefix = 'feed/';
            $url = $feed['feedId'];
            if (str_starts_with($url, $prefix)) {
                $url= substr($url, strlen($prefix));
            }

            $data = [
                'title' => $feed['title'],
                'image' => @$feed['coverUrl'],
                'subscribers' => $feed['subscribers'],
                'description' => @$feed['description'],
                'topics' => $feed['topics'],
                'url' => $url,
            ];

            $data["exists"] = $this->feedExists($data["url"]);

            $content->push($data);
        }

        $content->sortBy('subscribers');

        return $content->toArray();
    }

    private function feedExists(string $url): bool
    {
        return Feed::where('url','LIKE', $url)->exists();
    }

    public function getTopics(): array
    {
        $content = collect([]);

        foreach ($this->topics as $topic)
        {
            $content->push([
                'topic' => $topic['topic'],
                'subscribers' => $topic['size'],
            ]);
        }

        return $content->toArray();
    }

}
