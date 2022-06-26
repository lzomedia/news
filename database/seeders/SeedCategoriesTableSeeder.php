<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class SeedCategoriesTableSeeder extends Seeder
{

    public function run(): void
    {
        Category::create([
            'name' => 'News',
        ]);
    }
}
