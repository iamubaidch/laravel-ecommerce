<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategoriestableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Smartphones', 'slug' => Str::slug('smartphones'), 'image' => null, 'status' => 1],
            ['name' => 'Laptops', 'slug' => Str::slug('laptops'), 'image' => null, 'status' => 1],
            ['name' => 'Tablets', 'slug' => Str::slug('tablets'), 'image' => null, 'status' => 0],
            ['name' => 'Wearables', 'slug' => Str::slug('wearables'), 'image' => null, 'status' => 1],
            ['name' => 'TV & Home Theatre', 'slug' => Str::slug('tv-home-theatre'), 'image' => null, 'status' => 1],
        ];

        DB::table('categories')->insert($categories);

    }
}
