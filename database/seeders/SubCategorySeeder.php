<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use DB;

class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sub_categories')->insert([
            'name' => 'Subcategoria1',
            'category_id' => '1',
        ]);
        DB::table('sub_categories')->insert([
            'name' => 'Subcategoria2',
            'category_id' => '2',
        ]);
        DB::table('sub_categories')->insert([
            'name' => 'Subcategoria3',
            'category_id' => '5',
        ]);
        DB::table('sub_categories')->insert([
            'name' => 'Subcategoria4',
            'category_id' => '4',
        ]);
        DB::table('sub_categories')->insert([
            'name' => 'Subcategoria5',
            'category_id' => '1',
        ]);
    }
}
