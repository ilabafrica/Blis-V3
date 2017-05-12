<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_points', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()
                ->references('users')->on('id')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('system')->unsigned()
                  ->references('id')->on('codeable_concepts');
            $table->string('value');
            $table->integer('use')->unsigned()
                  ->references('id')->on('codeable_concepts');
            $table->integer('rank')->unsigned()->nullable();
            $table->date('period')->nullable();
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
        Schema::dropIfExists('contact_points');
    }
}
