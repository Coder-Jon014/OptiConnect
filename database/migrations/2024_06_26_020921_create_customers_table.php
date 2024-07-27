<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('customer_id');
            $table->string('customer_name');
            $table->string('telephone');
            // $table->unsignedBigInteger('town_id');
            $table->foreignId('town_id')->references('town_id')->on('towns')->onDelete('cascade');
            $table->unsignedBigInteger('customer_type_id');
            $table->foreign('customer_type_id')->references('customer_type_id')->on('customer_types')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customers');
    }
}

