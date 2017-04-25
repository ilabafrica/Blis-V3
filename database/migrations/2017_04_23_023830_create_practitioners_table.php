<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePractitionersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practitioners', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('active')->default(1);
            $table->integer('user_id')->unsigned()
                ->references('users')->on('id')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('name')
                ->references('human_names')->on('id')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('telecom')
                ->references('contact_points')->on('id')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('address')->nullable()
                ->references('addresses')->on('id')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('gender', ['male', 'female', 'other', 'unknown']);
            $table->date('birth_date');
            $table->string('photo')->nullable();
            //linked to practitioners qualification
            //linked to practitioners communication
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
        Schema::dropIfExists('practitioners');
    }
}
