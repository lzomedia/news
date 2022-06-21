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
            'title' => "IETF Blog",
            'user_id' => User::first()->id,
            'url' => "http://www.ietf.org/blog/feed/",
            'status' => Feed::INITIAL,
            'sync' => Carbon::parse('2001-01-01')
        ]);
    }
}
