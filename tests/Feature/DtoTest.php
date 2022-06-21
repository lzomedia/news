<?php

namespace Tests\Feature;

use App\DTO\Article;
use App\Factories\ExtractorFactory;
use App\Jobs\ProcessFeeds;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\DataTransferObject\Attributes\MapFrom;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Tests\TestCase;
use Illuminate\Support\Facades\Queue;

class DtoTest extends TestCase
{

    /**
     * @throws UnknownProperties
     */
    public function testArticleDto(): void
    {
        $data = [
            'title' => 'title',
            'authors' => ['author'],
            'source' => 'https://test.com',
            'date' => '2020-01-01 00:00:00',
            'content' => 'content',
            'images' => 'images',
            'timetoread' => '1',
        ];

        $dto = new Article($data);


        $this->assertEquals('title', $dto->getTitle());
        $this->assertEquals('author', $dto->getAuthors());
        $this->assertEquals('https://test.com', $dto->getSource());
        $this->assertEquals('2020-01-01 00:00:00', $dto->getDate());
        $this->assertEquals('content', $dto->getContent());
        $this->assertEquals('images', $dto->getImage());

    }
}
