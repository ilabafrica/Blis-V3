<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContainersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('containers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->Integer('type')->unsigned();
            $table->Integer('capacity');
            $table->Integer('quantity_id')->unsigned();
            $table->integer('additive')->unsigned(); //substance id
            $table->timestamps();

            //relationships
            $table->foreign('quantity_id')->references('id')->on('quantities')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('additive')->references('id')->on('substances')->onUpdate('cascade')->onDelete('cascade');
            
            $table->foreign('type')->references('id')->on('codeable_concepts')->onUpdate('cascade')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('containers');
    }
}
