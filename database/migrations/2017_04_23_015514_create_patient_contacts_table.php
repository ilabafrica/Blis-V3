<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('patient_id')
                ->references('patients')->on('id')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('relationship', [
                'emergency_contact',
                'employer',
                'federal_agency',
                'insurance_company',
                'next_of_kin',
                'other',
                'state_agency',
                'unknown'
            ]);
            $table->integer('name')
                ->references('human_names')->on('id')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('telecom')
                ->references('contact_points')->on('id')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('address')->nullable()
                ->references('addresses')->on('id')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('gender', ['male', 'female', 'other', 'unknown']);
            $table->integer('organization_id')->nullable()
                ->references('organizations')->on('id')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('patient_contacts');
    }
}
