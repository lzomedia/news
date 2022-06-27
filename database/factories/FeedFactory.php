<?php

namespace Database\Factories;

use App\Models\Feed;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class FeedFactory extends Factory
{
    public function definition(): array
    {
        $user = User::factory()->create();

        return [
            'title' => $this->faker->city,
            'user_id' => $user->id,
            'url' => "https://medium.com/feed/appstract",
            'status' => Feed::INITIAL,
            'sync' => Carbon::parse('2001-01-01')
        ];
    }
}
