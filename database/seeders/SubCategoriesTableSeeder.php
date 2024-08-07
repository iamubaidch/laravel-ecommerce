<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subCategories = [
            ['name' => 'Android Phones', 'slug' => Str::slug('android-phones'), 'status' => 1, 'category_id' => 1],
            ['name' => 'iPhones', 'slug' => Str::slug('iphones'), 'status' => 1, 'category_id' => 1],
            ['name' => 'Gaming Laptops', 'slug' => Str::slug('gaming-laptops'), 'status' => 1, 'category_id' => 2],
            ['name' => 'Ultrabooks', 'slug' => Str::slug('ultrabooks'), 'status' => 1, 'category_id' => 2],
            ['name' => 'Smartwatches', 'slug' => Str::slug('smartwatches'), 'status' => 1, 'category_id' => 4],
            ['name' => 'Fitness Trackers', 'slug' => Str::slug('fitness-trackers'), 'status' => 1, 'category_id' => 4],
            ['name' => 'projectors', 'slug' => Str::slug('projectors'), 'status' => 0, 'category_id' => 5],
            ['name' => 'LED', 'slug' => Str::slug('led'), 'status' => 1, 'category_id' => 5],
        ];

        DB::table('sub_categories')->insert($subCategories);
    }
}
