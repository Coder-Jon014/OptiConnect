<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParishesTable extends Migration
{
    public function up()
    {
        Schema::create('parishes', function (Blueprint $table) {
            $table->id('parish_id'); // Primary key
            $table->string('parish_name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('parishes');
    }
}
