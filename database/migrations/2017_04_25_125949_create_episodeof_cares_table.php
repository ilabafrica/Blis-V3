<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEpisodeofCaresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('episodeof_cares', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('status')->unsigned();
            $table->integer('type')->unsigned();
            $table->integer('patient_id')->unsigned();
            $table->integer('organization_id')->unsigned();
            $table->integer('period')->nullable();
            $table->integer('practitioners_id')->unsigned()->nullable();
            $table->integer('team_id')->unsigned()->nullable();
            $table->timestamps();


            //Relationships
            $table->foreign('status')->references('id')->on('statuses')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('type')->references('id')->on('codeable_concepts')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('patient_id')->references('id')->on('patients')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('organization_id')->references('id')->on('organizations')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('practitioners_id')->references('id')->on('practitioners')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('team_id')->references('id')->on('care_teams')->onUpdate('cascade')->onDelete('cascade');
            
        });

        Schema::table('care_teams', function(Blueprint $table){
            $table->foreign('context')->references('id')->on('episodeof_cares')->onUpdate('cascade')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('episodeof_cares');
    }
}
