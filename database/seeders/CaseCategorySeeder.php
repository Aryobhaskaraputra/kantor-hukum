<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CaseCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('legal_case_categories')->insert([
            ['case_categories_name' => 'Pidana'],
            ['case_categories_name' => 'Perdata']
        ]);
    }
}
