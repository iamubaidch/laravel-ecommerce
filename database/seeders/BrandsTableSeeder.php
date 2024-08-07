<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            ['name' => 'Samsung', 'slug' => Str::slug('samsung'), 'status' => 1],
            ['name' => 'Apple', 'slug' => Str::slug('apple'), 'status' => 1],
            ['name' => 'Vivo', 'slug' => Str::slug('vivo'), 'status' => 1],
            ['name' => 'Oppo', 'slug' => Str::slug('oppo'), 'status' => 1],
            ['name' => 'Realme', 'slug' => Str::slug('realme'), 'status' => 1],
            ['name' => 'Xiaomi', 'slug' => Str::slug('xiaomi'), 'status' => 1],
            ['name' => 'Infinix', 'slug' => Str::slug('infinix'), 'status' => 1],
            ['name' => 'Huawei', 'slug' => Str::slug('huawei'), 'status' => 0],
            ['name' => 'HP', 'slug' => Str::slug('hp'), 'status' => 1],
            ['name' => 'Dell', 'slug' => Str::slug('dell'), 'status' => 1],
            ['name' => 'Asus', 'slug' => Str::slug('asus'), 'status' => 1],
            ['name' => 'Lenovo', 'slug' => Str::slug('lenovo'), 'status' => 1],
            ['name' => 'Sony', 'slug' => Str::slug('sony'), 'status' => 1],
            ['name' => 'Aukey', 'slug' => Str::slug('aukey'), 'status' => 1],
            ['name' => 'Anker', 'slug' => Str::slug('anker'), 'status' => 1],
        ];

        DB::table('brands')->insert($brands);
    }
}
