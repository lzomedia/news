<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Feed;

class SeedFeedsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Feed::create([
            'title' => "TechCrunch",
            'user_id' => User::first()->id,
            'url' => "https://broke.com",
            'sync' => now()
        ]);
    }
}
