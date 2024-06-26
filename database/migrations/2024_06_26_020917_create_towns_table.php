<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTownsTable extends Migration
{
    public function up()
    {
        Schema::create('towns', function (Blueprint $table) {
            $table->id('town_id'); // Primary key
            $table->foreignId('parish_id')->constrained('parishes', 'parish_id')->onDelete('cascade'); // Foreign key
            $table->string('town_name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('towns');
    }
}
