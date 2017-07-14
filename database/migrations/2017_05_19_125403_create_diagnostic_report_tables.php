<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiagnosticReportTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Based on FHIR - https://www.hl7.org/fhir/diagnosticreport.html
        Schema::create('panel_types', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('code_id')->unsigned(); //R!  Name/Code for this diagnostic report(panel)
            $table->integer('status_id')->unsigned();;//Status (string or id)
            $table->integer('category_id')->unsigned(); // Service category (Heamatology, chemistry)

            //Several timestamps pending/ also responsible actors for various activites
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('category_id')->references('id')->on('codeable_concepts');
            $table->foreign('code_id')->references('id')->on('coding');
            $table->foreign('status_id')->references('id')->on('codeable_concepts');
        });

        Schema::create('panels', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('panel_type_id')->unsigned();
            $table->integer('performed_by')->unsigned();//User who performed this report
            $table->integer('specimen_id')->unsigned(); // Specimens this report is based on
            $table->string('conclusion'); // Clinical Interpretation of test results
            $table->integer('coded_diagnosis_id')->unsigned(); // Codes for the conclusion
            $table->integer('status_id')->unsigned();//Active\Inactive
            $table->integer('sort_order');
                    
            //Several timestamps pending/ also responsible actors for various activites
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('panel_type_id')->references('id')->on('panel_types');
            $table->foreign('performed_by')->references('id')->on('users');
            $table->foreign('specimen_id')->references('id')->on('specimens');
            $table->foreign('coded_diagnosis_id')->references('id')->on('codeable_concepts');
            $table->foreign('status_id')->references('id')->on('codeable_concepts');
        });

        //Based on https://www.hl7.org/fhir/observation.html
        Schema::create('observation_types', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('status_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->integer('code_id')->unsigned();
            $table->integer('result_type')->unsigned();
            $table->integer('sort_order');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('result_type')->references('id')->on('codeable_concepts');
            $table->foreign('category_id')->references('id')->on('codeable_concepts');
            $table->foreign('code_id')->references('id')->on('coding');
            $table->foreign('status_id')->references('id')->on('codeable_concepts');
        });

        Schema::create('observations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('status_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->integer('panel_id')->unsigned();
            $table->integer('observation_type_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('quantity_id')->unsigned();
            $table->integer('data_absent_reason')->unsigned();// Why the result is missing - CodeableConcept
            $table->integer('interpretation')->unsigned();
            $table->string('comment');
            $table->date('issued');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('category_id')->references('id')->on('codeable_concepts');
            $table->foreign('status_id')->references('id')->on('codeable_concepts');
            $table->foreign('panel_id')->references('id')->on('panels');
            $table->foreign('observation_type_id')->references('id')->on('observations');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('quantity_id')->references('id')->on('quantities');
            $table->foreign('data_absent_reason')->references('id')->on('codeable_concepts');
            $table->foreign('interpretation')->references('id')->on('codeable_concepts');
        });

        Schema::create('components', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('observation_id')->unsigned();
            $table->integer('performed_by')->unsigned();
            $table->string('result');
            $table->integer('data_absent_reason')->unsigned();
            $table->integer('interpretation')->unsigned();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('observation_id')->references('id')->on('observations');
            $table->foreign('performed_by')->references('id')->on('users');
            $table->foreign('data_absent_reason')->references('id')->on('codeable_concepts');
            $table->foreign('interpretation')->references('id')->on('codeable_concepts');
        });

        Schema::create('reference_ranges', function (Blueprint $table) {
            $table->increments('id');
            $table->float('low_normal');
            $table->float('high_normal');
            $table->float('low_critical');
            $table->float('high_critical');
            $table->integer('age_min');
            $table->integer('age_max');
            $table->integer('age_type')->unsigned();
            $table->integer('applies_to');
            $table->string('text');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('age_type')->references('id')->on('codeable_concepts');
        });

        Schema::create('component_types', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('code_id')->unsigned();
            $table->integer('result_type_id')->unsigned();
            $table->integer('reference_range_id')->unsigned();
            $table->integer('parent_id')->unsigned();//For sub-components

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('code_id')->references('id')->on('codeable_concepts');
            $table->foreign('result_type_id')->references('id')->on('codeable_concepts');
            $table->foreign('reference_range_id')->references('id')->on('reference_ranges');
            $table->foreign('parent_id')->references('id')->on('components');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('diagnostic_reports');
        Schema::dropIfExists('observations');
        Schema::dropIfExists('observations_types');
        Schema::dropIfExists('components');
        Schema::dropIfExists('component_types');
        Schema::dropIfExists('reference_ranges');
    }
}
