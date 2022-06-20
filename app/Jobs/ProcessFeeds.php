<?php

namespace App\Jobs;

use App\DTO\Article;
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

        $process = new Process([
            self::PYTHON,
            base_path(self::PYTHON_FILE_EXTRACT_REALTIME),
            $this->feed->url
        ]);

        $url = $this->feed->url;

        $process->run(function ($type, $buffer)  use ($url)
        {

            if(strlen($buffer) > 10) {

                $data = json_decode(
                    $buffer,
                    true,
                    512,
                    JSON_THROW_ON_ERROR
                );

                if (json_last_error() === 0) {
                    $dto = new Article($data);
                    $this->saveToDatabase($dto);
                }

            }

        });
        $this->feed->status = Feed::COMPLETED;
        $this->feed->save();
    }


    public function saveToDatabase(Article $articleDTO): void
    {
        $save =  (new \App\Models\Article)->firstOrCreate([
            'title' =>$articleDTO->getTitle(),
            'feed_id' => $articleDTO->getFeedId() ?? (new \App\Models\Feed)->first()->id,
            'category_id' => $this->createOrAttachCategory($articleDTO->getCategory())->id ?? (new \App\Models\Category)->first()->id,
            'image' => ($articleDTO->getImage()),
            'author' => ($articleDTO->getAuthors()),
            'source' => $articleDTO->getSource(),
            'content' => $articleDTO->getContent(),
            'created_at' => $articleDTO->getDate(),
        ]);

        $save->category()->increment('count');

        foreach ($articleDTO->getKeywords() as $tag) {
            $save->tags()->attach(
                (new \App\Models\Tag)->firstOrCreate(['name' => $tag])
            );
        }
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


    public function failed(): void
    {
        $this->feed->status = Feed::FAILED;
        $this->feed->save();
    }
}

