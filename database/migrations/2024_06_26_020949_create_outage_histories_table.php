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
            $table->unsignedBigInteger('olt_id')->nullable(); 
            $table->unsignedBigInteger('team_id')->nullable();
            $table->timestamp('start_time');
            $table->timestamp('end_time')->nullable();
            $table->integer('duration')->nullable();
            $table->text('resolution_details')->nullable();
            $table->timestamps();

            $table->foreign('olt_id')->references('olt_id')->on('olts')->onDelete('cascade');
            $table->foreign('team_id')->references('team_id')->on('teams')->onDelete('cascade');
            $table->boolean('status')->default(1);
        });
    }

    public function down()
    {
        Schema::dropIfExists('outage_histories');
    }
}
