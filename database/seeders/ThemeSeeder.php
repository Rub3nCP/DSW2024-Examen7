<?php

use Illuminate\Database\Seeder;
use App\Models\Theme;

class ThemeSeeder extends Seeder
{
    public function run()
    {
        Theme::create(['name' => 'Genérico']);
        Theme::create(['name' => 'Tema 1']);
        Theme::create(['name' => 'Tema 2']);
        Theme::create(['name' => 'Tema 3']);
    }
}