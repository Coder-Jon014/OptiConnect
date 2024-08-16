<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOltsTable extends Migration
{
    public function up()
    {
        Schema::create('olts', function (Blueprint $table) {
            $table->id('olt_id'); // Primary key
            $table->string('olt_name');
            $table->unsignedBigInteger('parish_id');
            $table->unsignedBigInteger('town_id');
            $table->integer('customer_count')->default(0);
            $table->integer('business_customer_count')->default(0);
            $table->integer('residential_customer_count')->default(0);
            $table->decimal('olt_value', 10, 2)->default(0);
            $table->string('level')->default('Low');
            $table->unsignedBigInteger('resource_id')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('parish_id')->references('parish_id')->on('parishes')->onDelete('cascade');
            $table->foreign('town_id')->references('town_id')->on('towns')->onDelete('cascade');
            $table->foreign('resource_id')->references('resource_id')->on('resources')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('olts');
    }
}
