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
            $table->integer('user_id')->unsigned()
                ->references('users')->on('id')->onUpdate('cascade')->onDelete('cascade');
            $table->boolean('active')->default(1);
            $table->integer('name')
                ->references('human_names')->on('id')->onUpdate('cascade')->onDelete('cascade');
//            $table->integer('telecom')
//                ->references('contact_points')->on('id')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('gender')->unsigned()
                  ->references('id')->on('codeable_concepts');
            $table->date('birth_date');
            $table->boolean('deceased')->default(0);
            $table->integer('address')
                ->references('addresses')->on('id')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('marital_status')->unsigned()
                  ->references('id')->on('codeable_concepts');
            $table->integer('multiple_birth')->default(0);
            $table->string('photo')->nullable();
            //linked to patient contact
            //If patient is animal fields
            $table->boolean('animal')->default(0);
            $table->string('animal_species')->nullable();
            $table->string('animal_breed')->nullable();
            $table->string('animal_gender_status')->nullable();
            //End of if patient is animal fields
            //linked to patient communication
            $table->enum('general_practitioner_type', ['organization', 'practitioner'])->nullable();
            $table->integer('general_practitioner_id')->nullable();
            $table->integer('managing_organization')->nullable()
                ->references('organizations')->on('id')->onUpdate('cascade')->onDelete('cascade');
            //linked to patient link
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
        Schema::dropIfExists('patients');
    }
}
