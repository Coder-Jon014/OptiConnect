<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('outage_types', function (Blueprint $table) {
            $table->id('outage_type_id');
            $table->string('outage_type_name');
            $table->unsignedBigInteger('resource_id');
            $table->timestamps();

            $table->foreign('resource_id')->references('resource_id')->on('resources')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outage_types');
    }
};
