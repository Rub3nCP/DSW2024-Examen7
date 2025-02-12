<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Topic;

class TopicsTableSeeder extends Seeder
{
    public function run()
    {
        Topic::create(['name' => 'Genérico']);
        Topic::create(['name' => 'Tecnología']);
        Topic::create(['name' => 'Cultura']);
        Topic::create(['name' => 'Deportes']);
    }
}