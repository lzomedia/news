<?php

namespace App\Jobs;

use App\Contracts\ArticleDatabaseContract;
use App\DTO\Article as ArticleDTO;

use App\Models\Feed;

use Illuminate\Bus\Queueable;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;


class ProcessFeeds implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Feed | Model $feed;

    private const PYTHON = 'python3';

    public int $timeout = 0;

    public string $memory = '512M';

    public string $message = 'This will send a message to the queue';

    private const PYTHON_FILE_EXTRACT_REALTIME = './python/extractor-realtime.py';

    public ArticleDatabaseContract $articleDatabaseContract;

    public function __construct(Feed | Model $feed, ArticleDatabaseContract $articleDatabaseContract)
    {
        $this->feed = $feed;
        $this->articleDatabaseContract = $articleDatabaseContract;
    }


    final public function handle(): void
    {
        try{
            $process = new Process([
                self::PYTHON,
                base_path(self::PYTHON_FILE_EXTRACT_REALTIME),
                $this->feed->url
            ]);

            $process->run(function ($type, $buffer)
            {
                Log::error("Output: $buffer");

                if(strlen($buffer) > 10) {

                    Log::error("Output: $buffer");

                    Log::error("Output: $buffer");

                    $data = json_decode(
                        $buffer,
                        true,
                        512,
                        JSON_THROW_ON_ERROR
                    );

                    if (json_last_error() === 0) {

                        $dto = new ArticleDTO($data);

                        $this->articleDatabaseContract->createArticle($dto);

                    }

                }

            });
        }catch (\Exception $exception){
            Log::error($exception->getTraceAsString());
            $this->delete();
        }

        $this->feed->status = Feed::COMPLETED;
        $this->feed->save();
    }

    public function failed(): void
    {
        $this->delete();
    }
}

