<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Models\Feed;

class SeedFeedsTableSeeder extends Seeder
{
    public function run(): void
    {
        Feed::create([
            'title' => "Laravel News",
            'user_id' => User::first()->id,
            'url' => "https://laravel-news.com/rss",
            'status' => Feed::INITIAL,
            'sync' => Carbon::parse('2001-01-01')
        ]);
    }
}
