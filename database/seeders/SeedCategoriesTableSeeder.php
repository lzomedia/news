<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class SeedCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Category 1',
        ]);
    }
}
