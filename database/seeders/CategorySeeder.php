<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            'name' => 'Categoria1',
        ]);
        DB::table('categories')->insert([
            'name' => 'Categoria2',
        ]);
        DB::table('categories')->insert([
            'name' => 'Categoria3',
        ]);
        DB::table('categories')->insert([
            'name' => 'Categoria4',
        ]);
        DB::table('categories')->insert([
            'name' => 'Categoria5',
        ]);
    }
}
