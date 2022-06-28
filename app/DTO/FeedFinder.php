<?php

namespace App\DTO;

use App\Models\Feed;
use Spatie\DataTransferObject\Attributes\MapFrom;
use Spatie\DataTransferObject\DataTransferObject;

class FeedFinder extends DataTransferObject
{
    #[MapFrom('feedInfos')]
    public ?array $feeds;

    #[MapFrom('relatedTopics')]
    public ?array $topics;

    public function getFeeds(): array
    {
        $content = collect([]);

        foreach ($this->feeds as $feed) {
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
                'website' => @$feed['website'],
                'score'=> $feed['leoScore'] ?? 0,
                'url' => $url,
            ];

            $data["exists"] = $this->feedExists($data["url"]);

            $content->push($data);
        }

        $content->sortBy('subscribers', $options = SORT_REGULAR, $descending = true);

        return $content->toArray();
    }

    private function feedExists(string $url): bool
    {
        return Feed::where('url', 'LIKE', $url)->exists();
    }

    public function getTopics(): array
    {
        $content = collect([]);

        foreach ($this->topics as $topic) {
            $content->push([
                'topic' => $topic['topic'],
                'subscribers' => $topic['size'],
            ]);
        }

        return $content->toArray();
    }
}
