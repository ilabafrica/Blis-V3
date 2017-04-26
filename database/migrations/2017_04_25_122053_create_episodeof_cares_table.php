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
            $table->integer('patient')->unsigned();
            $table->integer('managing_organization')->unsigned();
            $table->integer('period')->nullable();
            $table->integer('care_manager')->unsigned()->nullable();
            $table->integer('team')->unsigned()->nullable();
            $table->timestamps();


            //Relationships
            $table->foreign('status')->references('id')->on('statuses')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('type')->references('id')->on('codeable_concepts')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('patient')->references('id')->on('patients')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('managing_organization')->references('id')->on('organizations')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('care_manager')->references('id')->on('practitioners')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('team')->references('id')->on('teams')->onUpdate('cascade')->onDelete('cascade');
            
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
