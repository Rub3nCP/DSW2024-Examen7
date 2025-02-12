<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNameColumnToThemesTable extends Migration
{
    public function up()
    {
        Schema::table('themes', function (Blueprint $table) {
            $table->string('name');
        });
    }

    public function down()
    {
        Schema::table('themes', function (Blueprint $table) {
            $table->dropColumn('name');
        });
    }
}


