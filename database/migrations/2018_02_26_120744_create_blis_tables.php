<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlisTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * @system https://www.hl7.org
         * @code Code defined by a terminology system
         * @text Plain text representation of the concept
         */
        Schema::create('codeable_concepts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->string('text');
            $table->timestamps();
        });

        /**
         * @system https://www.hl7.org/fhir/datatypes.html#HumanName
         * @use usual|official|temp|nickname|anonymous|old|maiden
         * @text representation of the full name
         * @prefix Parts that come before the name|Mr|Dr|Mrs
         * @surffix Parts that come after the name
         */
        Schema::create('names', function (Blueprint $table) {
            $table->increments('id');
            $table->string('use',20)->default('usual');
            $table->string('text');
            $table->string('family')->nullable();
            $table->string('given')->nullable();
            $table->string('prefix')->nullable();
            $table->string('suffix')->nullable();
            $table->timestamps();
        });

        /**
         * @system https://www.hl7.org/fhir/datatypes.html#ContactPoint
         * @example phone|fax|email|pager|url|sms|other
         * @use home|work|temp|old|mobile
         */
        Schema::create('telecoms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('patient_id')->unsigned();
            $table->string('system',20)->default('phone');
            $table->string('value');
            $table->string('use',20)->nullable();
            $table->integer('rank')->unsigned()->nullable();
            $table->timestamps();
        });

        /**
         * @system https://www.hl7.org/fhir/datatypes.html#Address
         */
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('patient_id')->unsigned();
            $table->string('text');
            $table->string('line')->nullable();
            $table->string('city')->nullable();
            $table->string('district')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country')->nullable();
            $table->string('period')->nullable();
            $table->timestamps();
        });

        /**
         * @system https://www.hl7.org/fhir/organization.html
         * @example hospitals|laboratories
         */
        Schema::create('organizations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('identifier')->nullable();
            $table->integer('created_by')->unsigned()->references('id')->on('users');
            $table->boolean('active')->default(1);
            $table->integer('organization_type_id')->unsigned();
            $table->string('name');
            $table->string('alias')->nullable();
            $table->string('telecom')->nullable();
            $table->string('address')->nullable();
            $table->timestamps();
        });

        /**
         * @system https://www.hl7.org/fhir/codesystem-administrative-gender.html
         * @code male|female|both|unknown
         * @display Male|Female|both|Unknown
         */
        Schema::create('genders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code',10);
            $table->string('display');
        });

        /**
         * @system https://www.hl7.org/fhir/practitioner.html
         * @description details of the clinician
         */
        Schema::create('practitioners', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('active')->default(1);
            $table->integer('created_by')->unsigned()
                ->references('id')->on('users');
            $table->integer('name')
                ->references('id')->on('names')->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('telecom')->nullable()
                ->references('id')->on('telecoms')->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('address')->nullable()
                ->references('id')->on('addresses')->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('gender_id')->unsigned();
            $table->date('birth_date')->nullable();
            $table->string('photo')->nullable();
            $table->string('qualification')->nullable();
            $table->timestamps();

            $table->foreign('gender_id')->references('id')->on('genders');
        });

        /**
         * @system blis.v3 defined
         */
        Schema::create('species', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->string('display');
        });

        /**
         * @system blis.v3 defined
         */
        Schema::create('breeds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('species_id')->unsigned();
            $table->string('code');
            $table->string('display');
        });

        /**
         * @system https://www.hl7.org/fhir/valueset-marital-status.html#expansion
         */
        Schema::create('marital_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->string('display');
            $table->string('definition')->nullable();
        });

        /**
         * @system https://www.hl7.org/fhir/patient.html
         * @animal if patient is animal
         */
        Schema::create('patients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('identifier'); //Business identifier
            $table->boolean('active')->default(1);
            $table->integer('name_id')->unsigned();
            $table->integer('telecom_id')->unsigned()->nullable();
            $table->integer('gender_id')->unsigned();
            $table->date('birth_date');
            $table->boolean('deceased')->default(0)->nullable();
            $table->date('deceased_date_time')->nullable();
            $table->integer('address_id')->unsigned()->nullable();
            $table->integer('marital_status')->unsigned()->nullable();
            $table->string('photo')->nullable();
            $table->boolean('animal')->default(0)->nullable();
            $table->integer('species_id')->unsigned()->nullable();
            $table->integer('breed_id')->unsigned()->nullable();
            $table->string('gender_status')->nullable();
            $table->integer('practitioner_id')->unsigned()->nullable();
            $table->integer('organization_id')->unsigned()->nullable();
            $table->integer('created_by')->unsigned();

            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('name_id')->references('id')->on('names');
            $table->foreign('telecom_id')->references('id')->on('telecoms');
            $table->foreign('gender_id')->references('id')->on('genders');
            $table->foreign('address_id')->references('id')->on('addresses');
            $table->foreign('practitioner_id')->references('id')->on('practitioners');
            $table->foreign('organization_id')->references('id')->on('organizations');
            $table->foreign('species_id')->references('id')->on('species');
            $table->foreign('breed_id')->references('id')->on('breeds');
            $table->foreign('marital_status')->references('id')->on('marital_statuses');
        });

        /**
         * @system blis.v3 defined
         */
        Schema::create('specimen_types', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('code', 45);
            $table->string('name', 100)->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        /**
         * @system blis.v3 defined
         */
        Schema::create('test_type_categories', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('code',100)->unique()->nullable();
            $table->string('name',100);

            $table->softDeletes();
            $table->timestamps();
        });

        /**
         * @system blis.v3 defined
         * @code numeric|alphanumeric|multiAlphanumeric|cultureAndSensitivities|freetext
         * @description multiAlphanumeric is multiple submission of results like in
         * gram stain
         */
        Schema::create('measure_types', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('code', 60)->nullable();
            $table->string('name');

            $table->softDeletes();
        });

        /**
         * @system blis.v3 defined
         * @example Malaria Microscopy|Organisms|Gram Stains|Stool Microscopy
         */
        Schema::create('measures', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('measure_type_id')->unsigned();
            $table->string('name', 100);
            $table->string('unit', 30)->nullable();
            $table->string('description', 150)->nullable();

            $table->foreign('measure_type_id')->references('id')->on('measure_types');

            $table->timestamps();
            $table->softDeletes();
        });

        /**
         * @system blis.v3 defined
         * @code positive|negative|normal|high|low|critically_low|critically_high
         */
        Schema::create('interpretations', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('code', 60)->nullable();
            $table->integer('name')->unsigned()->nullable();

            $table->softDeletes();
        });

        /**
         * @system multiple sources
         * @code numerous
         * @alphanumeric +|++|+++|Positive|E.Coli|Gram Positive
         * @interpretation_id for the alphanumeric and cultureAndSensitivity
         */
        Schema::create('measure_ranges', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('code')->nullable();
            $table->string('system')->nullable();
            $table->integer('measure_id')->unsigned();
            $table->decimal('age_min')->nullable();
            $table->decimal('age_max')->nullable();
            $table->integer('gender_id')->unsigned();
            $table->decimal('low', 7, 3)->nullable();
            $table->decimal('high', 7, 3)->nullable();
            $table->decimal('low_critical', 7, 3)->nullable();
            $table->decimal('high_critical', 7, 3)->nullable();
            $table->string('alphanumeric_range');
            $table->integer('interpretation_id')->unsigned()->nullable();

            $table->softDeletes();
            $table->foreign('gender_id')->references('id')->on('genders');
            $table->foreign('measure_id')->references('id')->on('measures');
            $table->foreign('interpretation_id')
                ->references('id')->on('interpretations');
        });

        /**
         * @system blis.v3 defined
         * @code S|I|R
         * @text Sensitive|Intermediate|Resistant
         */
        Schema::create('susceptibility_ranges', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('code',2);
            $table->string('name',20);
        });

        /**
         * @system blis.v3 defined
         */
        Schema::create('test_types', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('description', 100)->nullable();
            $table->integer('test_type_category_id')->unsigned();
            $table->string('targetTAT', 50)->nullable();

            $table->foreign('test_type_category_id')
                ->references('id')->on('test_type_categories');

            $table->softDeletes();
            $table->timestamps();
        });

        /**
         * @system blis.v3 defined
         */
        Schema::create('testtype_measures', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('test_type_id')->unsigned();
            $table->integer('measure_id')->unsigned();

            $table->foreign('test_type_id')->references('id')->on('test_types');
            $table->foreign('measure_id')->references('id')->on('measures');
            $table->unique(array('test_type_id','measure_id'));
        });

        /**
         * @system blis.v3 defined
         */
        Schema::create('test_type_specimen_types', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('test_type_id')->unsigned();
            $table->integer('specimen_type_id')->unsigned();

            $table->foreign('test_type_id')->references('id')->on('test_types');
            $table->foreign('specimen_type_id')->references('id')->on('specimen_types');
            $table->unique(array('test_type_id','specimen_type_id'));
        });

        /**
         * @system blis.v3 defined
         * @name pre-analytic|analytic|post-analytic 
         */
        Schema::create('test_phases', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name',45);
        });

        /**
         * @system blis.v3 defined
         */
        Schema::create('test_statuses', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name',45);
            $table->integer('test_phase_id')->unsigned();

            $table->foreign('test_phase_id')->references('id')->on('test_phases');
        });

        /**
         * @system https://www.hl7.org/fhir/specimen.html
         * @name available|unavailable|unsatisfactory|entered-in-error
         */
        Schema::create('specimen_statuses', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name',20);
        });
        /**
         * @system blis.v3 defined
         * @example wards|clinics
         */
        Schema::create('locations', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('identifier', 45);
            $table->string('name', 100);
        });

        /**
         * @system blis.v3 defined
         */
        Schema::create('encounter_statuses', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name',45);
        });

        /**
         * @system blis.v3 defined
         */
        Schema::create('encounter_classes', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name',45);
        });

        /**
         * @system https://www.hl7.org/fhir/encounter.html
         * @identifier Identifier(s) by which this encounter is known
         * @encounter_class_id inpatient|outpatient|ambulatory|emergency
         * @encounter_status_id planned|arrived|triaged|in-progress|onleave|finished|cancelled
         */
        Schema::create('encounters', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('identifier')->nullable();
            $table->integer('patient_id')->unsigned();
            $table->integer('location_id')->nullable();
            $table->integer('encounter_class_id')->unsigned()->nullable();
            $table->integer('encounter_status_id')->unsigned()->nullable();
            $table->string('bed_no')->nullable();

            $table->foreign('patient_id')->references('id')->on('patients');
            $table->foreign('encounter_class_id')->references('id')->on('patients');
            $table->foreign('encounter_status_id')
                ->references('id')->on('encounter_statuses');
            $table->timestamps();
        });

        /**
         * @system blis.v3 defined
         */
        Schema::create('rejection_reasons', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string("name", 100);
        });

        /**
         * @system blis.v3 defined
         */
        Schema::create('referral_reasons', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string("name", 100);
        });

        /**
         * @system blis.v3 defined
         */
        Schema::create('referrals', function(Blueprint $table)
        {
            $table->increments('id');
            $table->timestamp('time_dispatch')->nullable();
            $table->string('storage_condition', 20);
            $table->string('transport_type', 20);
            $table->integer('referral_reason_id')->unsigned()->nullable();
            $table->string('priority_specimen', 20);
            $table->integer('organization_id')->unsigned();
            $table->string('person', 500);
            $table->text('contacts');
            $table->integer('user_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('organization_id')
                ->references('id')->on('organizations');
            $table->foreign('referral_reason_id')
                ->references('id')->on('referral_reasons');

            $table->timestamps();
        });

        /**
         * @system blis.v3 defined
         */
        Schema::create('collections', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('collector_id')->unsigned();
            $table->timestamp('collection_date_time');

            $table->foreign('collector_id')->references('id')->on('users');
        });

        /**
         * @system blis.v3 defined
         * @specimen_status_id available|unavailable|unsatisfactory|entered-in-error
         * @identifier External Identifier
         * @accession_identifier Identifier assigned by the lab
         * @parent_id Specimen from which this specimen originated
         */
        Schema::create('specimens', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('identifier')->nullable();
            $table->string('accession_identifier');
            $table->integer('specimen_type_id')->unsigned();
            $table->integer('parent_id')->unsigned();
            $table->integer('specimen_status_id')->unsigned();
            $table->integer('received_by')->unsigned();
            $table->timestamp('time_collected')->nullable();
            $table->timestamp('received_time')->nullable();

            $table->index('received_by');
            $table->foreign('specimen_type_id')->references('id')->on('specimen_types');
            $table->foreign('specimen_status_id')->references('id')->on('specimen_statuses');
        });

        /**
         * @system blis.v3 defined
         * @identifier Unique ID for external records
         */
        Schema::create('tests', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('encounter_id')->unsigned();
            $table->integer('identifier')->nullable();
            $table->integer('test_type_id')->unsigned();
            $table->integer('specimen_id')->unsigned()->default(0);
            $table->integer('test_status_id')->unsigned()->default(0);
            $table->integer('created_by')->unsigned();
            $table->integer('tested_by')->unsigned()->default(0);
            $table->integer('verified_by')->unsigned()->default(0);
            $table->string('requested_by',60);
            $table->timestamp('time_started')->nullable();
            $table->timestamp('time_completed')->nullable();
            $table->timestamp('time_verified')->nullable();
            $table->timestamp('time_sent')->nullable();
            $table->timestamps();

            $table->index('created_by');
            $table->index('tested_by');
            $table->index('verified_by');
            $table->foreign('encounter_id')->references('id')->on('encounters');
            $table->foreign('test_type_id')->references('id')->on('test_types');
            $table->foreign('specimen_id')->references('id')->on('specimens');
            $table->foreign('test_status_id')->references('id')->on('test_statuses');
        });

        /**
         * @system blis.v3 defined
         * @test_id entered if test phase is analytic phase
         */
        Schema::create('specimen_rejections', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('specimen_id')->unsigned();
            $table->integer('test_phase_id')->unsigned();
            $table->integer('test_id')->unsigned()->nullable();
            $table->integer('rejected_by')->unsigned();
            $table->integer('rejection_reason_id')->unsigned()->nullable();
            $table->string('reject_explained_to',100)->nullable();
            $table->timestamp('time_rejected')->nullable();

            $table->index('rejected_by');
            $table->foreign('test_id')->references('id')->on('tests');
            $table->foreign('test_phase_id')->references('id')->on('test_phases');
            $table->foreign('specimen_id')->references('id')->on('specimens');
            $table->foreign('rejection_reason_id')
                ->references('id')->on('rejection_reasons');
        });

        /**
         * @system blis.v3 defined
         * @description isolated organisms and gram results also listed
         */
        Schema::create('results', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('test_id')->unsigned();
            $table->integer('measure_id')->unsigned();
            $table->string('result',1000)->nullable();
            $table->integer('measure_range_id')->unsigned()->nullable();
            $table->timestamp('time_entered')->default(DB::raw('CURRENT_TIMESTAMP'));
            
            $table->foreign('test_id')->references('id')->on('tests');
            $table->foreign('measure_id')->references('id')->on('measures');
            $table->unique(array('test_id','measure_id','measure_range_id'));
        });

        /**
         * @system blis.v3 defined
         */
        Schema::create('antibiotics', function($table)
        {
            $table->increments('id');
            $table->string('code');
            $table->string('name');
        });     

        /**
         * @system blis.v3 defined
         * @description used for both isolated organisms and gram stain culture
         */
        Schema::create('antibiotic_susceptibilities', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('antibiotic_id')->unsigned();
            $table->integer('result_id')->unsigned();
            $table->integer('susceptibility_range_id')->unsigned();
            $table->integer('zone_diameter')->unsigned()->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('antibiotic_id')->references('id')->on('antibiotics');
            $table->foreign('result_id')->references('id')->on('results');
            $table->foreign('susceptibility_range_id')
                ->references('id')->on('susceptibility_ranges');
        });

        /**
         * @system blis.v3 defined
         * @description used for both isolated organisms and gram stain
         */
        Schema::create('susceptibility_break_points', function($table)
        {
            $table->increments('id');
            $table->integer('antibiotic_id')->unsigned();
            $table->integer('measure_range_id')->unsigned();
            $table->decimal('resistant_max', 4, 1)->nullable();
            $table->decimal('intermediate_min', 4, 1)->nullable();
            $table->decimal('intermediate_max', 4, 1)->nullable();
            $table->decimal('sensitive_min', 4, 1)->nullable();

            $table->foreign('antibiotic_id')->references('id')->on('antibiotics');
            $table->foreign('measure_range_id')->references('id')->on('measure_ranges');
        });

        /**
         * @system blis.v3 defined
         * @example asscession_identifier|patient_report|monthly_report
         */
        Schema::create('adhoc_categories', function($table)
        {
            $table->increments('id');
            $table->string('code',60)->nullable();
            $table->string('display');
        });

        /**
         * @system blis.v3 defined
         * @example monthly-reset-ulin|kayunga_iso|standard
         */
        Schema::create('adhoc_options', function($table)
        {
            $table->increments('id');
            $table->integer('adhoc_category_id')->unsigned();
            $table->string('code',60)->nullable();
            $table->string('display');

            $table->foreign('adhoc_category_id')
                ->references('id')->on('adhoc_categories');
        });

        /**
         * @system blis.v3 defined
         * @description incrementing and resetting patient accession_identifier
         */
        Schema::create('counter', function(Blueprint $table)
        {
            $table->increments('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('counter');
        Schema::dropIfExists('adhoc_options');
        Schema::dropIfExists('adhoc_categories');
        Schema::dropIfExists('susceptibility_break_points');
        Schema::dropIfExists('antibiotic_susceptibilities');
        Schema::dropIfExists('antibiotics');
        Schema::dropIfExists('results');
        Schema::dropIfExists('specimen_rejections');
        Schema::dropIfExists('tests');
        Schema::dropIfExists('specimens');
        Schema::dropIfExists('collections');
        Schema::dropIfExists('referrals');
        Schema::dropIfExists('referral_reasons');
        Schema::dropIfExists('rejection_reasons');
        Schema::dropIfExists('encounters');
        Schema::dropIfExists('encounter_classes');
        Schema::dropIfExists('encounter_statuses');
        Schema::dropIfExists('locations');
        Schema::dropIfExists('specimen_statuses');
        Schema::dropIfExists('test_statuses');
        Schema::dropIfExists('test_phases');
        Schema::dropIfExists('test_type_specimen_types');
        Schema::dropIfExists('testtype_measures');
        Schema::dropIfExists('test_types');
        Schema::dropIfExists('susceptibility_ranges');
        Schema::dropIfExists('measure_ranges');
        Schema::dropIfExists('interpretations');
        Schema::dropIfExists('measures');
        Schema::dropIfExists('measure_types');
        Schema::dropIfExists('test_type_categories');
        Schema::dropIfExists('specimen_types');
        Schema::dropIfExists('patients');
        Schema::dropIfExists('marital_statuses');
        Schema::dropIfExists('breeds');
        Schema::dropIfExists('species');
        Schema::dropIfExists('practitioners');
        Schema::dropIfExists('genders');
        Schema::dropIfExists('organizations');
        Schema::dropIfExists('addresses');
        Schema::dropIfExists('telecoms');
        Schema::dropIfExists('names');
        Schema::dropIfExists('codeable_concepts');
    }
}
