<?php

namespace App\Jobs;

use App\DTO\Article;
use App\Models\Category;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SaveToDatabase implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Article $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    public function handle(): void
    {
        $article =  (new \App\Models\Article)->firstOrCreate([
            'title' => $this->article->getTitle(),
            'feed_id' => $this->article->getFeedId() ??
                (new \App\Models\Feed)->first()->id,
            'category_id' => $this->createOrAttachCategory()->id ??
                (new \App\Models\Category)->first()->id,
            'image' => ($this->article->getImage()),
            'author' => ($this->article->getAuthors()),
            'source' => $this->article->getSource(),
            'content' => $this->article->getContent(),
        ]);
        $article->category()->associate($this->createOrAttachCategory());
        $article->category()->increment('count');

        foreach ($this->article->getKeywords() as $tag) {
            $article->tags()->attach(
                (new \App\Models\Tag)->firstOrCreate(['name' => $tag])
            );
        }
    }


    private function createOrAttachCategory(): Category
    {
        $category = (new \App\Models\Category)
            ->where('name', $this->article->getCategory())
            ->first();

        if(is_null($category)){
            $category =  (new \App\Models\Category)->create([
                'name' => $this->article->getCategory(),
            ]);
        }
        return $category;
    }
}
