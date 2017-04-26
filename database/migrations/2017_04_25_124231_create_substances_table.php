<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubstancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('substances', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('status'); //status id
            $table->integer('category')->unsigned(); //codeable concept id
            $table->integer('code')->unsigned(); //codeable concept id
            $table->string('description')->nullable(); 
            $table->timestamps();

            //Relationships
            $table->foreign('category')->references('id')->on('codeable_concepts')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('status')->references('id')->on('statuses')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('code')->references('id')->on('codeable_concepts')->onUpdate('cascade')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('substances');
    }
}
