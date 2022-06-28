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
            function ( $type , $buffer)
            {
                Log::info($buffer);
                Log::info($type);
            }
        );

        $this->info('Processing of feeds finished & jobs where dispatched.');
    }
}
