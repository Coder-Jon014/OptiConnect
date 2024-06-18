<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOltsTable extends Migration
{
    public function up()
    {
        Schema::create('olts', function (Blueprint $table) {
            $table->id('olt_id');
            $table->string('olt_name');
            $table->foreignId('parish_id')->constrained('parishes')->onDelete('cascade');
            $table->foreignId('town_id')->constrained('towns')->onDelete('cascade');
            $table->integer('customer_count');
            $table->integer('business_customer_count');
            $table->integer('residential_customer_count');
            $table->foreignId('resource_id')->constrained('resources')->onDelete('cascade');
            $table->decimal('olt_value', 10, 2);
            $table->integer('rank'); // Added rank
            $table->string('level'); // Added level (e.g., High, Low)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('olts');
    }
}
