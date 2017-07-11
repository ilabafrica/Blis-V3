<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('identifier'); //Business identifier
            $table->integer('created_by')->unsigned();
            $table->boolean('active')->default(1);
            $table->integer('name')->unsigned();
            $table->integer('telecom')->unsigned();
            $table->integer('gender')->unsigned();
            $table->date('birth_date');
            $table->boolean('deceased')->default(0);
            $table->date('deceased_date_time');
            $table->integer('address')->unsigned();
            $table->integer('marital_status')->unsigned();
            $table->string('photo')->nullable();
            //If patient is animal fields
            $table->boolean('animal')->default(0);
            $table->string('animal_species')->nullable();
            $table->string('animal_breed')->nullable();
            $table->string('animal_gender_status')->nullable();
            $table->integer('managing_organization')->unsigned();

            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('name')->references('id')->on('human_names');
            $table->foreign('telecom')->references('id')->on('contact_points');
            $table->foreign('gender')->references('id')->on('code');
            $table->foreign('address')->references('id')->on('addresses');
            $table->foreign('managing_organization')->references('id')->on('organizations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
}
