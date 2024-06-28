
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResourceTeamTable extends Migration
{
    public function up()
    {
        Schema::create('resource_team', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('team_id');
            $table->unsignedBigInteger('resource_id');
            $table->timestamps();

            $table->foreign('team_id')->references('team_id')->on('teams')->onDelete('cascade');
            $table->foreign('resource_id')->references('resource_id')->on('resources')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('resource_team');
    }
}
