<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecimensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specimens', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('accessionIdentifier')->nullable(); // Identifier assigned by the lab
            $table->integer('status')->unsigned(); //status id
            $table->integer('type')->unsigned();
            $table->string('subject');
            $table->dateTime('receivedTime');
            $table->integer('parent')->nullable();
            $table->string('note')->nullable();
            $table->timestamps();

            //Relationships
            
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
        Schema::dropIfExists('specimens');
    }
}
