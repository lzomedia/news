<?php

namespace Tests\Unit;

use App\DTO\Article;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Tests\TestCase;

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
