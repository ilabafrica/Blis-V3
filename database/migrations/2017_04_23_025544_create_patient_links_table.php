<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_links', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('patient_id')
                ->references('patients')->on('id')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('other')
                ->references('patients')->on('id')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('type')->unsigned()
                  ->references('id')->on('codeable_concepts');
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
        Schema::dropIfExists('patient_links');
    }
}
