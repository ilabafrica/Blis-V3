<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCareTeamPractitionersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('care_team_practitioners', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('team_id')->unsigned();
            $table->integer('practioner_id')->unsigned();
            $table->timestamps();

            //Relationships
            $table->foreign('team_id')->references('id')->on('care_teams')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('practioner_id')->references('id')->on('practitioners')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('care_team_practitioners');
    }
}
