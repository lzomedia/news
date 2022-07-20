<?php

namespace App\DTO;

use App\Jobs\DiscoverFeeds;
use App\Models\Category;
use App\Models\Feed;
use Carbon\Carbon;
use Spatie\DataTransferObject\Attributes\MapFrom;
use Spatie\DataTransferObject\DataTransferObject;
use Symfony\Component\DomCrawler\Crawler;

class Reactions extends DataTransferObject
{
    #[MapFrom('article_id')]
    public ?string $id;

    #[MapFrom('time_to_read')]
    public ?string $timeToRead;

    #[MapFrom('vader')]
    public string $vader;
}
