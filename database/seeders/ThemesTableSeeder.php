<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ThemesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('themes')->insert([
            ['name' => 'Genérico'],
            ['name' => 'Tema1'],
            ['name' => 'Tema2'],
            ['name' => 'Tema3'],
        ]);
    }
}