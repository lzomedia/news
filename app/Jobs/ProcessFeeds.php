<?php

namespace App\Jobs;

use App\Contracts\ArticleContract;
use App\Contracts\SyncContract;
use App\Contracts\UserContract;
use App\DTO\Article as ArticleDTO;


use App\Models\Article;
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


    private int $feedID;

    public function __construct(int $feedID)
    {
        $this->feedID = $feedID;
    }

    final public function handle(): void
    {

        $userContract = app(UserContract::class);

        $syncContract = app(SyncContract::class);

        $articleContract = app(ArticleContract::class);

        $feedRepo = new FeedRepository($userContract);

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
            $process->setTimeout(180);

            $process->run(
                function ($type, $buffer) use ($articleContract) {
                    if (strlen($buffer) > 10) {

                        $data = json_decode(
                            $buffer,
                            true,
                            512,
                            JSON_THROW_ON_ERROR
                        );

                        if (json_last_error() === 0) {

                            $dto = new ArticleDTO($data);

                            if (Config::get('cms.enable_discovery_feeds')) {
                                $dto->discoverFeeds();
                            }


                            if (!$articleContract->checkIfArticleExists($dto)) {
                                /** @var Article $articleModel */
                                $article = $articleContract->createArticle($dto);

                                if (Config::get('cms.enable_ping_feeds'))
                                {
                                    dispatch(new PingPost($articleContract,$article->id ))
                                    ->onQueue('ping')
                                    ->delay(now()->addSeconds(random_int(1, 10)));
                                }
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
