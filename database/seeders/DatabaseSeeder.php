<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


        // Run the factories
        // \App\Models\Category::factory(30)->create();
        // \App\Models\SubCategory::factory(30)->create();



        // \App\Models\Product::factory(30)->create();
        // Run the seeders
        //     $this->call(CategoriesTableSeeder::class);
        //     $this->call(SubCategoriesTableSeeder::class);
        //     $this->call(BrandsTableSeeder::class);
    }
}
