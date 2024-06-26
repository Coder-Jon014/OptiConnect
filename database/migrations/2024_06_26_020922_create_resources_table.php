<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResourcesTable extends Migration
{
    public function up()
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->id('resource_id');
            $table->string('resource_name'); // e.g., Bucket-Truck, Splicer, Cable Engineer, Fiber Technician, Bucket Vane
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('resources');
    }
}
