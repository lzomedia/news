<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\ArticleTags;
use App\Models\Tag;

class SeedArticleTagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        ArticleTags::create([
            'article_id' => Article::first()->id,
            'tag_id' => Tag::first()->id,
        ]);
    }
}
