<?php

// database/migrations/2024_06_17_233926_create_teams_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamsTable extends Migration
{
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id('team_id');
            $table->string('team_name');
            $table->string('team_type');
            $table->unsignedBigInteger('resource_id')->nullable(); // Make this column nullable
            $table->foreign('resource_id')->references('resource_id')->on('resources')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('teams');
    }
}
