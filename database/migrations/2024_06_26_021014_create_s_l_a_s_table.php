<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSLAsTable extends Migration
{
    public function up()
    {
        Schema::create('slas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_type_id');
            $table->unsignedBigInteger('outage_history_id');
            $table->float('max_duration');
            $table->text('compensation_details');
            $table->timestamps();

            $table->foreign('customer_type_id')->references('customer_type_id')->on('customer_types')->onDelete('cascade');
            $table->foreign('outage_history_id')->references('id')->on('outage_histories')->onDelete('cascade');

            $table->float('residential_customer_value')->nullable();
            $table->float('business_customer_value')->nullable();
            $table->float('refund_amount')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('slas');
    }
}
