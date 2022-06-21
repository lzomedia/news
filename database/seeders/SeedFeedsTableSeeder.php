<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Feed;

class SeedFeedsTableSeeder extends Seeder
{

    public function run(): void
    {
        Feed::create([
            'title' => "Appstract",
            'user_id' => User::first()->id,
            'url' => "https://medium.com/feed/appstract",
            'status' => Feed::INITIAL,
            'sync' => Carbon::parse('2001-01-01')
        ]);

        Feed::create([
            'title' => "CodeAnchor",
            'user_id' => User::first()->id,
            'url' => "https://www.codeanchor.net/feed",
            'status' => Feed::INITIAL,
            'sync' => Carbon::parse('2001-01-01')
        ]);
    }
}
