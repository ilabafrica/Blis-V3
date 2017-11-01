<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReferralRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referral_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('based_on')->unsigned()->nullable(); //episode of care
            $table->integer('replaces')->unsigned()->nullable();  //Request(s) replaced by this request
            $table->integer('group_identifier')->unsigned()->nullable();  //Request(s) replaced by this request
            $table->integer('status')->unsigned();
            $table->integer('type')->unsigned();
            $table->integer('priority')->nullable();
            $table->string('service_requested')->nullable();
            $table->integer('subject')->nullable()->unsigned();
            $table->dateTime('occurence')->nullable();
            $table->integer('requester')->unsigned();
            $table->integer('specialty')->unsigned();
            $table->integer('recipient')->unsigned();
            $table->integer('reason_code')->unsigned()->nullable();
            $table->string('reason_reference')->nullable();
            $table->string('supporting_info')->nullable();
            $table->string('description')->nullable();
            $table->string('note')->nullable();
            $table->timestamps();

            //Relationships
            $table->foreign('based_on')->references('id')->on('episodeof_cares')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('replaces')->references('id')->on('referral_requests')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('status')->references('id')->on('statuses')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('type')->references('id')->on('codeable_concepts')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('subject')->references('id')->on('patients')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('specialty')->references('id')->on('codeable_concepts')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('recipient')->references('id')->on('practitioners')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('referral_requests');
    }
}
