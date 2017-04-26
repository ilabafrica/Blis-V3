<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcedureRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('procedure_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('definition_id')->unsigned()->nullable();
            $table->string('based_on')->nullable();
            $table->string('replaces')->nullable();
            $table->integer('requisition')->nullable();
            $table->string('status');
            $table->string('intent');
            $table->string('priority');
            $table->boolean('do_not_perform');
            $table->integer('category')->unsigned();
            $table->integer('code')->unsigned();
            $table->string('subject');
            $table->integer('context')->unsigned();  // Encounter or Episode during which request was created
            $table->dateTime('occurence');
            $table->integer('asneeded');
            $table->dateTime('authored_on');
            $table->integer('requester')->unsigned();
            $table->integer('performer_type')->unsigned();
            $table->integer('performer')->unsigned();
            $table->integer('reason_code')->unsigned()->nullable();
            $table->string('reason_reference')->nullable();
            $table->string('supporting_info')->nullable();
            $table->integer('specimen')->unsigned()->nullable();
            $table->integer('body_site')->unsigned();
            $table->string('note')->nullable();
            $table->string('relevant_history')->nullable(); 
            $table->timestamps();

            //Relationships
            $table->foreign('category')->references('id')->on('codeable_concepts')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('code')->references('id')->on('codeable_concepts')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('context')->references('id')->on('episodeof_cares')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('requester')->references('id')->on('practitioners')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('performer_type')->references('id')->on('codeable_concepts')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('performer')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('reason_code')->references('id')->on('codeable_concepts')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('body_site')->references('id')->on('codeable_concepts')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('specimen')->references('id')->on('specimens')->onUpdate('cascade')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('procedure_requests');
    }
}
