<?php

namespace App\Jobs;

use App\Contracts\ArticleContract;
use App\DTO\Article as ArticleDTO;

use App\Models\Feed;

use Illuminate\Bus\Queueable;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;

class ProcessFeeds implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private const PYTHON = 'python3';

    private const PYTHON_FILE_EXTRACT_REALTIME = './python/extractor-realtime.py';

    public ArticleContract $articleContract;

    private int $feed_id;

    public function __construct(int $feed_id, ArticleContract $articleContract)
    {
        $this->feed_id = $feed_id;

        $this->articleContract = $articleContract;
    }


    final public function handle(): void
    {
        $feed = Feed::find($this->feed_id);

        try {
            $process = new Process(
                [
                self::PYTHON,
                base_path(self::PYTHON_FILE_EXTRACT_REALTIME),
                $feed->url,
                ]
            );
            //increased the time of a process to 3 minutes
            $process->setTimeout(180);

            $process->run(
                function ($type, $buffer) {
                    Log::error("Output: $buffer");

                    if (strlen($buffer) > 10) {
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
                            $dto->discoverFeeds();

                            if (!$this->articleContract->checkIfArticleExists($dto)) {
                                $this->articleContract->createArticle($dto);
                            }

                        }
                    }
                }
            );
        } catch (\Exception $exception) {
            Log::error($exception->getTraceAsString());
            $this->delete();
        }

        $feed->status = Feed::COMPLETED;
        $feed->save();
    }

    public function failed(): void
    {
        $this->delete();
    }
}
