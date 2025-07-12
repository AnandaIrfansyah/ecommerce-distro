<?php

namespace Database\Seeders;

use App\Models\Categories;
use App\Models\Size;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sizesByCategory = [
            'Tops' => ['XS', 'S', 'M', 'L', 'XL', 'XXL'],
            'Bottoms' => ['28', '30', '32', '34', '36', '38'],
            'Footwear' => ['38', '39', '40', '41', '42', '43', '44', '45'],
            'Accessories' => ['Adjustable']
        ];

        foreach ($sizesByCategory as $categoryName => $sizes) {
            $category = Categories::where('name', $categoryName)->first();

            if (!$category) {
                continue;
            }

            foreach ($sizes as $size) {
                Size::create([
                    'name' => $size,
                    'category_id' => $category->id
                ]);
            }
        }
    }
}
