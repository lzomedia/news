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

class Article extends DataTransferObject
{
    #[MapFrom('id')]
    public ?string $id;

    #[MapFrom('title')]
    public ?string $title;

    #[MapFrom('authors')]
    public ?array $authors;

    #[MapFrom('date')]
    public ?string $date;

    #[MapFrom('content')]
    public ?string $content;

    #[MapFrom('images')]
    public ?string $image;

    #[MapFrom('source')]
    public ?string $source;

    #[MapFrom('keywords')]
    public ?array $keywords;

    #[MapFrom('vader')]
    public ?array $vader;

    #[MapFrom('timetoread')]
    public ?string $timetoread;


    #[MapFrom('original_content')]
    public ?string $original_content;

    /**
     * @return string|null
     */
    public function getOriginalContent(): ?string
    {
        return $this->original_content;
    }


    public ?Category $category;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getAuthors(): ?string
    {
        return $this->authors[0] ?? 'Stefan';
    }

    public function getDate(): ?string
    {
        return Carbon::parse($this->date)->toDateTimeString();
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function getCategory(): Category
    {
        return (new Category())->firstOrCreate(
            [
                'name' => $this->getKeywords()[0] ?? "News"
            ]
        );
    }

    public function getKeywords(): ?array
    {
        return $this->keywords;
    }

    public function discoverFeeds(): void
    {
        $crawler = new Crawler($this->getOriginalContent());

        $results = $crawler->filter('a')->each(
            function (Crawler $node) {
                return parse_url($node->attr('href'))['host'];
            }
        );

        $domains = array_unique($results);

        foreach ($domains as $domain) {
            $exists = Feed::where('url', 'LIKE', $domain)->exists();

            if (!$exists) {
                dispatch(new DiscoverFeeds($domain));
            }
        }
    }

    public function getFeedId(): ?string
    {
        return $this->feed_id ?? "1";
    }

    public function getVader(): ?array
    {
        return $this->vader;
    }

    public function getTimeToRead(): ?string
    {
        return $this->timetoread;
    }
}
