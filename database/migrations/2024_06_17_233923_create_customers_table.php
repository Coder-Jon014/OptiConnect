<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id('customer_id'); // Primary key
            $table->string('customer_name');
            $table->string('telephone');
            $table->foreignId('town_id')->constrained('towns')->onDelete('cascade');
            $table->foreignId('customer_type_id')->constrained('customer_types')->onDelete('cascade'); // Foreign key
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
