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
            $table->string('customer_name')->index(); // Adding index for customer_name
            $table->string('telephone')->index(); // Adding index for telephone
            $table->foreignId('town_id')->constrained('towns', 'town_id')->onDelete('cascade')->index(); // Adding index for town_id
            $table->unsignedBigInteger('customer_type_id')->index(); // Adding index for customer_type_id
            $table->foreign('customer_type_id')->references('customer_type_id')->on('customer_types')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
