<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlasTable extends Migration
{
    public function up()
    {
        Schema::create('slas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_type_id')->constrained('customer_types')->onDelete('cascade');
            $table->float('max_duration'); // in hours
            $table->string('compensation_details');
            $table->foreignId('outage_history_id')->constrained('outage_histories')->onDelete('cascade'); // Linking to outage history
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('slas');
    }
}
