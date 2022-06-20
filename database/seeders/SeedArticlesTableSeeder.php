<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Article;
use App\Models\Category;
use App\Models\Feed;

class   SeedArticlesTableSeeder extends Seeder
{

    public function run(): void
    {
        Article::create([
            'feed_id' => Feed::first()->id,
            'title' => "It Foss",
            'image' => 'http://placekitten.com/500/200',
            'author' => 'Stefan',
            'category_id' => Category::first()->id,
            'content' => 'Some long content',
            'source' => 'https://url.com',
            'published_at' => Carbon::now()
        ]);
    }
}
