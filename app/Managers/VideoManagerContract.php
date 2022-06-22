<?php

namespace App\Managers;

use App\Contracts\VideoGeneratorContract;
use App\Models\Article;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use App\Contracts\ArticleDatabaseContract;

class VideoManagerContract implements VideoGeneratorContract
{

    public ArticleDatabaseContract $articleDatabase;

    public function __construct(ArticleDatabaseContract $articleDatabase)
    {
        $this->articleDatabase = $articleDatabase;
    }

    public function generateVideo(): void
    {

        Log::info('Generating video for article');

    }

    public function getVideosForArticle(int $article_id): Collection
    {
        // TODO: Implement getVideosForArticle() method.
        return collect([]);
    }


}

