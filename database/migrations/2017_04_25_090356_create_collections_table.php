<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collections', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('collector')->unsigned();
            $table->dateTime('collection_time');
            $table->integer('quantity_id')->unsigned();
            $table->integer('method')->unsigned();
            $table->integer('body_site')->unsigned();
            $table->timestamps();


            //relationships
            $table->foreign('collector')->references('id')->on('practitioners')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('quantity_id')->references('id')->on('quantities')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('method')->references('id')->on('codeable_concepts')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('body_site')->references('id')->on('codeable_concepts')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('collections');
    }
}
