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
            $table->integer('basedOn')->unsigned()->nullable(); //episode of care
            $table->integer('replaces')->unsigned()->nullable();  //Request(s) replaced by this request
            $table->integer('group_identifier')->unsigned()->nullable();  //Request(s) replaced by this request
            $table->integer('status')->unsigned(); 
            $table->integer('type')->unsigned(); 
            $table->integer('priority')->nullable(); 
            $table->string('serviceRequested')->nullable(); 
            $table->integer('serviceRequested')->nullable()->unsigned(); 
            $table->dateTime('occurence')->nullable(); 
            $table->integer('requester')->unsigned(); 
            $table->integer('specialty')->unsigned(); 
            $table->integer('recipient')->unsigned(); 
            $table->integer('reason_code')->unsigned()->nullable();
            $table->string('reason_reference')->unsigned()->nullable();
            $table->string('supporting_info')->nullable();
            $table->string('description')->nullable();
            $table->string('note')->nullable();
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
        Schema::dropIfExists('referral_requests');
    }
}
