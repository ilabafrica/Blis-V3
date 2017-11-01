<?php

//https://www.hl7.org/fhir/datatypes.html#codesystem

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCodingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('codings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uri'); // Identity of the terminology system
            $table->string('version'); // Version of the system - if relevant
            $table->string('code'); // Symbol in syntax defined by the system
            $table->string('display'); // Representation defined by the system
            $table->boolean('userSelected'); // If this coding was chosen directly by the user

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('codings');
    }
}
