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
            $table->integer('definition_id')->unsigned();
            $table->string('based_on')->nullable();
            $table->string('replaces')->nullable();
            $table->integer('requisition')->nullable();
            $table->string('status');
            $table->string('intent');
            $table->string('priority');
            $table->boolean('do_not_perform');
            $table->smallInteger('category')->unsigned();
            $table->smallInteger('code')->unsigned();
            $table->string('subject');
            $table->integer('context')->unsigned();  // Encounter or Episode during which request was created
            $table->dateTime('occurence');
            $table->smallInteger('asneeded');
            $table->dateTime('authored_on');
            $table->integer('requester')->unsigned();
            $table->smallInteger('performer_type')->unsigned();
            $table->integer('performer')->unsigned();
            $table->integer('reason_code')->unsigned()->nullable();
            $table->string('reason_reference')->unsigned()->nullable();
            $table->string('supporting_info')->nullable();
            $table->integer('specimen')->unsigned();
            $table->smallInteger('body_site')->unsigned();
            $table->string('note')->nullable();
            $table->string('relevant_history')->nullable(); 
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
        Schema::dropIfExists('procedure_requests');
    }
}
