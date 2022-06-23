<?php

namespace App\Console\Commands;

use App\Contracts\ArticleContract;
use App\DTO\Article;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;

class Processor extends Command
{
    protected $signature = 'processor:run {url}';

    protected $description = 'This command will run and extract the data from the feeds';

    private ArticleContract $articleDatabaseContract;

    public function __construct(ArticleContract $articleDatabaseContract)
    {
        parent::__construct();

        $this->articleDatabaseContract = $articleDatabaseContract;
    }

    public function handle(): void
    {
        $url = $this->argument('url');

        $process = new Process(
            [
            'python3',
            base_path('python/extractor-realtime.py'),
            $url
            ]
        );

        $process->run(
            function ($type, $buffer) use ($url) {
                Log::error("Output: {$buffer}");

                if (strlen($buffer) > 10) {
                    Log::error("Output: {$buffer}");

                    Log::error("Url: {$url}");

                    Log::error("Output: {$buffer}");

                    $data = json_decode(
                        $buffer,
                        true,
                        512,
                        JSON_THROW_ON_ERROR
                    );

                    if (json_last_error() === 0) {
                        $dto = new Article($data);

                        $this->articleDatabaseContract->createArticle($dto);
                    }
                }
            }
        );

        $this->info('Processing of feeds finished & jobs where dispatched.');
    }
}
