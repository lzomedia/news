<?php

namespace App\Jobs;

use App\DTO\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;


class ProcessFeeds implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $feedLink;

    private const PYTHON = 'python3';

    public int $timeout = 0;

    public string $memory = '512M';

    public string $message = 'This will send a message to the queue';

    private const PYTHON_FILE_EXTRACT_REALTIME = 'python/extractor-realtime.py';

    public function __construct(string $feedLink)
    {
        $this->feedLink = $feedLink;
    }

    final public function handle(): void
    {

        $process = new Process([
            self::PYTHON,
            base_path(self::PYTHON_FILE_EXTRACT_REALTIME),
            $this->feedLink
        ]);

        $url = $this->feedLink;

        $process->run(function ($type, $buffer)  use ($url)
        {
            $data = json_decode(
                $buffer,
                true,
                512,
                JSON_THROW_ON_ERROR
            );

            $dto = new Article($data);

            dispatch(new SaveToDatabase($dto));

        });
    }
}

