<?php

namespace App\Console\Commands;

use App\Contracts\ArticleContract;
use App\Services\VideoManager;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class VideoGenerator extends Command
{
    protected $signature = 'video:generate';

    protected $description = 'This command will run and extract the data from the feeds';

    private ArticleContract $articleContract;

    public function __construct(ArticleContract $articleContract)
    {
        parent::__construct();

        $this->articleContract = $articleContract;
    }

    public function handle(): void
    {
        $this->info('Started the generation of a video from the article');

        $article = $this->articleContract->getArticleById(3);

        try {
            $manager = new VideoManager();

            $manager->generateVideo($article);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
