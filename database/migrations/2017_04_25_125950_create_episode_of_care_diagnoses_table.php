<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEpisodeOfCareDiagnosesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('episode_of_care_diagnoses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('condition');
            $table->string('role');
            $table->string('rank');
            $table->integer('episode_of_care_id')->unsigned();
            $table->timestamps();

            //Relationships
            $table->foreign('episode_of_care_id')->references('id')->on('episodeof_cares')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('episode_of_care_diagnoses');
    }
}
