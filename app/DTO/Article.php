<?php

namespace App\DTO;

use App\Jobs\DiscoverFeeds;
use Carbon\Carbon;
use Spatie\DataTransferObject\Attributes\MapFrom;
use Spatie\DataTransferObject\DataTransferObject;

class Article extends DataTransferObject
{
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

    public ?string $category;

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
        return $this->date;
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

    public function getCategory(): string
    {
        return $this->getKeywords()[0] ?? 'News';
    }

    public function getKeywords(): ?array
    {
        return $this->keywords;
    }

    public function discoverFeeds(): void
    {

        $links = Crawler::links($this->getContent());

        dispatch(new DiscoverFeeds($links));
    }
}
