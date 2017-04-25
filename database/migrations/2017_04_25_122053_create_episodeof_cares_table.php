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
