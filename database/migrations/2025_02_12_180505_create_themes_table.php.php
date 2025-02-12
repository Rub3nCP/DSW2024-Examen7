<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

Schema::create('themes', function (Blueprint $table) {
    $table->id();
    $table->string('name')->unique();
    $table->timestamps();
});

class ThemesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('themes')->insert([
            ['name' => 'Genérico', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Tecnología', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ciencia', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Arte', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(ThemesTableSeeder::class);
    }
}