<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ['name' => 'Tops', 'icon' => 'fas fa-tshirt'],
            ['name' => 'Bottoms', 'icon' => 'fas fa-grip-lines'],
            ['name' => 'Accessories', 'icon' => 'fas fa-hat-cowboy'],
            ['name' => 'Footwear', 'icon' => 'fas fa-shoe-prints'],
        ]);
    }
}
