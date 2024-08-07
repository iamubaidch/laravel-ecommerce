<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->name;
        $slug = Str::slug($title);
        $subCategories = [3, 4, 11];
        $subCatRandom = array_rand($subCategories);

        $brands = [9, 10, 11];
        $brandRandom = array_rand($brands);

        $qty = [5, 7, 9, 10, 11];
        $qtyRandom = array_rand($qty);


        return [
            'title' => $title,
            'slug' => $slug,
            'category_id' => 2,
            'sub_category_id' => $subCategories[$subCatRandom],
            'brand_id' => $brands[$brandRandom],
            'price' => rand(10, 1000),
            'sku' => rand(1000, 9000),
            'track_qty' => 'Yes',
            'qty' => $qty[$qtyRandom],
            'is_featured' => 'Yes',
            'status' => 1,
        ];
    }
}
