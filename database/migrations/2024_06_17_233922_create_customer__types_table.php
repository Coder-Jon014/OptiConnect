<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerTypesTable extends Migration
{
    public function up()
    {
        Schema::create('customer_types', function (Blueprint $table) {
            $table->id('customer_type_id'); // Primary key
            $table->string('customer_type_name');
            $table->decimal('customer_value', 8, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customer_types');
    }
}
