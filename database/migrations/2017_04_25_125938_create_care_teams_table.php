<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCareTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('care_teams', function (Blueprint $table) {
            $table->increments('id');
            $table->string('identifiers')->nullable();
            $table->integer('status_id')->unsigned(); //status id
            $table->integer('category')->unsigned();
            $table->string('name');
            $table->integer('subject')->nullable()->unsigned();
            $table->integer('context')->unsigned(); //episode of care id
            $table->integer('period')->nullable();
            $table->integer('reason_code')->nullable()->unsigned();
            $table->string('reason_reference')->nullable();
            $table->integer('organization_id')->unsigned(); //org id
            $table->string('comment')->nullable();
            $table->timestamps();

            //Relationships
            $table->foreign('status_id')->references('id')->on('statuses')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('category')->references('id')->on('codeable_concepts')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('care_teams');
    }
}
