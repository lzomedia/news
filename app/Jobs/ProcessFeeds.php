<?php

namespace App\Jobs;

use App\Contracts\ArticleContract;
use App\DTO\Article as ArticleDTO;


use App\Repositories\FeedRepository;
use Illuminate\Bus\Queueable;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;

class ProcessFeeds implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private const PYTHON = 'python3';

    public string $message = "Some message";

    private const PYTHON_FILE_EXTRACT_REALTIME = './python/extractor-realtime.py';

    public ArticleContract $articleContract;

    private int $feedID;

    public function __construct(int $feedID, ArticleContract $articleContract)
    {
        $this->feedID = $feedID;

        $this->articleContract = $articleContract;
    }


    final public function handle(): void
    {
        $feedRepo = new FeedRepository();

        $feed = $feedRepo->getFeedById($this->feedID);

        Log::info("Processing feed: " . $feed->url);

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
                    if (strlen($buffer) > 10) {
                        Log::error("Output: $buffer");

                        $data = json_decode(
                            $buffer,
                            true,
                            512,
                            JSON_THROW_ON_ERROR
                        );

                        if (json_last_error() === 0) {

                            $dto = new ArticleDTO($data);

                            if(Config::get('cms.enable_discovery_feeds')){
                                $dto->discoverFeeds();
                            }


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
    }

    public function failed(): void
    {
        $this->delete();
    }
}
