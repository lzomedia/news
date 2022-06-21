<?php

namespace App\Jobs;

use App\DTO\Article as ArticleDTO;
use App\Models\Category;
use App\Models\Feed;
use App\Models\Article as ArticleModel;
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

    public Feed $feed;

    private const PYTHON = 'python3';

    public int $timeout = 0;

    public string $memory = '512M';

    public string $message = 'This will send a message to the queue';

    private const PYTHON_FILE_EXTRACT_REALTIME = './python/extractor-realtime.py';

    public function __construct(Feed $feed)
    {
        $this->feed = $feed;
    }


    final public function handle(): void
    {

        try {
            $process = new Process([
                self::PYTHON,
                base_path(self::PYTHON_FILE_EXTRACT_REALTIME),
                $this->feed->url
            ]);

            $process->run(function ($type, $buffer)
            {
                Log::error("Output: {$buffer}");

                if(strlen($buffer) > 10) {

                    Log::error("Output: {$buffer}");

                    $data = json_decode(
                        $buffer,
                        true,
                        512,
                        JSON_THROW_ON_ERROR
                    );

                    if (json_last_error() === 0) {
                        $dto = new ArticleDTO($data);
                        $this->saveToDatabase($dto);
                    }

                }

            });
        }catch (\Exception $exception){
            Log::error($exception->getTraceAsString());
            $this->feed->status = Feed::FAILED;
            $this->feed->save();
            $this->delete();

        }
        $this->feed->status = Feed::COMPLETED;
        $this->feed->save();
    }


    /**
     * @throws \JsonException
     */
    public function saveToDatabase(ArticleDTO $articleDTO): void
    {

        //create a category
        $category =  $this->createOrAttachCategory($articleDTO->getCategory());

        //create article
        $articleModel =  (new \App\Models\Article)->firstOrCreate([
            'title' => $articleDTO->getTitle(),
            'feed_id' => $this->feed->id,
            'category_id' => $category->id,
            'image' => $articleDTO->getImage(),
            'author' => $articleDTO->getAuthors(),
            'source' => $articleDTO->getSource(),
            'content' => $articleDTO->getContent(),
            'published_at' => $articleDTO->getDate(),
        ]);

        //increment category
        $articleModel->category()->increment('count');

        //create tags
        foreach ($articleDTO->getKeywords() as $tag) {
            $articleModel->tags()->attach(
                (new \App\Models\Tag)->firstOrCreate(['name' => $tag])
            );
        }

        //create article info
        $this->createArticleInfo($articleModel, $articleDTO);
    }

    private function createOrAttachCategory(string $categoryName): Category
    {
        $category = (new \App\Models\Category)
            ->where('name', $categoryName)
            ->first();

        if(is_null($category)){
            $category =  (new \App\Models\Category)->create([
                'name' => $categoryName
            ]);
        }
        return $category;
    }


    private function createArticleInfo(ArticleModel $article, ArticleDTO $articleDTO): void
    {

        $articleInfo = (new \App\Models\ArticleInfo)->firstOrCreate([
            'article_id' => $article->id,
            'time_to_read' => $articleDTO->getTimetoread(),
            'vader' => json_encode($articleDTO->getVader(), JSON_THROW_ON_ERROR),
        ]);

        $article->save();
    }

    public function failed(): void
    {
        $this->feed->status = Feed::FAILED;
        $this->feed->save();
        $this->delete();

    }
}

