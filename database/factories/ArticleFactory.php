<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'category_id' => 1,
            'feed_id' => 1,
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
            'summary' => $this->faker->paragraph,
            'author' => $this->faker->name,
            'image' => $this->faker->imageUrl,
            'source' => $this->faker->url,
            'published_at' => $this->faker->dateTimeBetween('-1 years', 'now'),
        ];
    }

}
