<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatusHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('code')->unsigned();
            $table->integer('episode_of_care_id')->unsigned();
            $table->timestamps();

            //Relationships
            $table->foreign('code')->references('id')->on('codeable_concepts')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('status_histories');
    }
}
