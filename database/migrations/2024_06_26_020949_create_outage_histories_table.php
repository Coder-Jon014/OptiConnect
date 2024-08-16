<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutageHistoriesTable extends Migration
{
    public function up()
    {
        Schema::create('outage_histories', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('olt_id')->nullable()->index(); // Index for faster lookups
            $table->unsignedBigInteger('team_id')->nullable()->index(); // Index for faster lookups
            $table->unsignedBigInteger('outage_type_id')->nullable()->index(); // Index for faster lookups
            $table->timestamp('start_time')->index(); // Index for faster time range queries
            $table->timestamp('end_time')->nullable()->index(); // Index for faster time range queries
            $table->bigInteger('duration')->nullable();
            $table->text('resolution_details')->nullable();
            $table->timestamps();
            $table->boolean('status')->default(1);

            // Foreign keys
            $table->foreign('olt_id')->references('olt_id')->on('olts')->onDelete('cascade');
            $table->foreign('team_id')->references('team_id')->on('teams')->onDelete('cascade');
            $table->foreign('outage_type_id')->references('outage_type_id')->on('outage_types')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('outage_histories');
    }
}
