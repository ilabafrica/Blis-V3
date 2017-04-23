<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientCommunicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_communications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('patient_id')
                ->references('patients')->on('id')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('language', ['sw', 'en', 'fr', 'es', 'de', 'ar', 'zh']);
            $table->boolean('preferred')->default(1);
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
        Schema::dropIfExists('patient_communications');
    }
}
