<?php

namespace App\Services;

use App\DTO\FeedFinder;
use Illuminate\Support\Facades\Http;

use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class FeedService
{
    /**
     * @throws UnknownProperties
     * @throws \JsonException
     */
    public function find(string $topic): FeedFinder
    {

        $data = Http::get('https://feedly.com/v3/recommendations/topics/'.$topic.'?locale=en')
            ->body();


        return new FeedFinder(
            json_decode($data, true, 512, JSON_THROW_ON_ERROR)
        );

    }
}
