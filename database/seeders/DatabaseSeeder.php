<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'stefan@lzomedia.com',
            'password' => bcrypt('password'),
        ]);
        $this->call([
            SeedFeedsTableSeeder::class,
            SeedCategoriesTableSeeder::class,
            SeedTagsTableSeeder::class,
            SeedArticlesTableSeeder::class,
            SeedArticleTagsTableSeeder::class
        ]);
    }
}
