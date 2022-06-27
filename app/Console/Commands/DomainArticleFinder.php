<?php

namespace App\Console\Commands;

use App\Contracts\ArticleContract;
use App\DTO\Article;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;

class DomainArticleFinder extends Command
{
    protected $signature = 'article:domain {url}';

    protected $description = 'This command will extract the latest articles from a given url';

    public function handle(): void
    {
        $url = $this->argument('url');

        $process = new Process(
            [
            'python3',
            base_path('python/domain-articles-extractor.py'),
            $url
            ]
        );

        $process->setTimeout(180);

        $process->run(

            function ($type, $buffer) use ($url) {
               $this->info($buffer);
            }
        );

        $this->info('Processing of feeds finished & jobs where dispatched.');
    }
}
