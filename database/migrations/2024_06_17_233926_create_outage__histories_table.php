<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutageHistoriesTable extends Migration
{
    public function up()
    {
        Schema::create('outage_histories', function (Blueprint $table) {
            $table->id('outage_id');
            $table->foreignId('olt_id')->constrained('olts')->onDelete('cascade');
            $table->foreignId('team_id')->constrained('teams')->onDelete('cascade');
            $table->timestamp('start_time');
            $table->timestamp('end_time')->nullable();
            $table->integer('duration')->nullable(); // in minutes
            $table->text('resolution_details')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('outage_histories');
    }
}
