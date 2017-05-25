<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePractitionerQualificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practitioner_qualifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('practitioner_id')
                ->references('practitioners')->on('id')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name');
            $table->date('period')->nullable();
            $table->integer('issuer')->nullable()
                ->references('organizations')->on('id')->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('practitioner_qualifications');
    }
}
