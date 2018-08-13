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
        // Create table for storing roles
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Create table for associating roles to users (Many-to-Many)
        Schema::create('role_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('role_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        // Create table for storing permissions
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Create table for associating permissions to roles (Many-to-Many)
        Schema::create('permission_role', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('permission_id')->unsigned();
            $table->integer('role_id')->unsigned();

            $table->foreign('permission_id')->references('id')->on('permissions')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        /*
         * @system Multiple
         * @name Code System Name: LOINC|FHIR|CLSI|ISO
         * @link Url to online resource
         * @description additional information
         */
        Schema::create('code_systems', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('link');
            $table->string('description');
            $table->timestamps();
        });

        /*
         * @system Multiple
         * @code male|female|234|etc
         * @display UI text of the code
         * @description additional information
         */
        Schema::create('codes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('code_system_id')->unsigned();
            $table->string('code');
            $table->string('display');
            $table->string('description');
            $table->timestamps();
            $table->foreign('code_system_id')->references('id')->on('code_systems');
        });

        /*
         * @system https://www.hl7.org/fhir/datatypes.html#HumanName
         * @use usual|official|temp|nickname|anonymous|old|maiden
         * @text representation of the full name
         * @prefix Parts that come before the name|Mr|Dr|Mrs
         * @surffix Parts that come after the name
         */
        Schema::create('names', function (Blueprint $table) {
            $table->increments('id');
            $table->string('use', 20)->default('usual');
            $table->string('text')->nullable();
            $table->string('family')->nullable();
            $table->string('given')->nullable();
            $table->string('prefix')->nullable();
            $table->string('suffix')->nullable();
            $table->timestamps();
        });

        /*
         * @system https://www.hl7.org/fhir/organization.html
         * @example hospitals|laboratories
         */
        Schema::create('organizations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('identifier')->nullable();
            $table->integer('created_by')->unsigned();
            $table->boolean('active')->default(1);
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('alias')->nullable();
            $table->string('telecom')->nullable();
            $table->string('address')->nullable();
            $table->timestamps();
        });

        /*
         * @system https://www.hl7.org/fhir/codesystem-administrative-gender.html
         * @code male|female|both|unknown
         * @display Male|Female|both|Unknown
         */
        Schema::create('genders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 10);
            $table->string('display', 10);
        });

        /*
         * @system https://www.hl7.org/fhir/patient.html
         * @animal if patient is animal
         */
        Schema::create('patients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('identifier'); //Business identifier
            $table->string('ulin')->nullable(); //unique lab identification number
            $table->boolean('active')->default(1);
            $table->integer('name_id')->unsigned();
            $table->integer('gender_id')->unsigned();
            $table->date('birth_date');
            $table->boolean('deceased')->default(0);
            $table->date('deceased_date_time')->nullable();
            $table->string('address')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('photo')->nullable();
            $table->integer('organization_id')->unsigned()->nullable();
            $table->string('created_by')->nullable();

            $table->timestamps();

            $table->foreign('name_id')->references('id')->on('names');
            $table->foreign('gender_id')->references('id')->on('genders');
            $table->foreign('organization_id')->references('id')->on('organizations');
        });

        /*
         * @system blis.v3 defined
         */
        Schema::create('specimen_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 45)->nullable();
            $table->string('name', 100);

            $table->softDeletes();
            $table->timestamps();
        });

        /*
         * @system blis.v3 defined
         */
        Schema::create('test_type_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 100)->nullable();
            $table->string('name', 100);

            $table->softDeletes();
            $table->timestamps();
        });

        /*
         * @system blis.v3 defined
         * @code numeric|alphanumeric|multiAlphanumeric|cultureAndSensitivities|freetext
         * @description multiAlphanumeric is multiple submission of results like in
         * gram stain
         */
        Schema::create('measure_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 60)->nullable();
            $table->string('name');

            $table->softDeletes();
        });

        /*
         * @system blis.v3 defined
         * @example Malaria Microscopy|Organisms|Gram Stains|Stool Microscopy
         */
        Schema::create('measures', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('test_type_id')->unsigned();
            $table->integer('measure_type_id')->unsigned();
            $table->string('name', 100);
            $table->string('unit', 30)->nullable();
            $table->string('description', 150)->nullable();

            $table->foreign('measure_type_id')->references('id')->on('measure_types');

            $table->timestamps();
            $table->softDeletes();
        });

        /*
         * @system blis.v3 defined
         * @code [used on measure_ranges for alphanumeric ranges, multi and culture]
         *       positive|negative|reactive|non-reactive|MicroB-growth|MicroB-non-growth|
         *
         *       [used on in reporting for numeric ranges]
         *       normal|high|low|critically_low|critically_high
         */
        Schema::create('interpretations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 60)->nullable();
            $table->string('name')->nullable();

            $table->softDeletes();
        });

        /*
         * @system multiple sources
         * @code numerous
         * @alphanumeric[display] +|++|+++|Positive|E.Coli|Gram Positive(i.e. include gram stains and organisms)
         * @interpretation_id for the alphanumeric[display] and cultureAndSensitivity
         */
        Schema::create('measure_ranges', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('code_id')->unsigned()->nullable();
            $table->integer('measure_id')->unsigned();
            $table->decimal('age_min')->nullable();
            $table->decimal('age_max')->nullable();
            $table->integer('gender_id')->unsigned()->nullable();
            $table->decimal('low', 7, 3)->nullable();
            $table->decimal('high', 7, 3)->nullable();
            $table->decimal('low_critical', 7, 3)->nullable();
            $table->decimal('high_critical', 7, 3)->nullable();
            $table->string('display')->nullable(); // alphanumeric option
            $table->integer('interpretation_id')->unsigned()->nullable();

            $table->softDeletes();
            $table->foreign('measure_id')->references('id')->on('measures');
        });

        /*
         * @system blis.v3 defined
         * @code S|I|R
         * @text Sensitive|Intermediate|Resistant
         */
        Schema::create('susceptibility_ranges', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 2);
            $table->string('name', 20);
        });

        /*
         * @system blis.v3 defined
         */
        Schema::create('test_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('description', 100)->nullable();
            $table->integer('test_type_category_id')->unsigned();
            $table->string('targetTAT', 50)->nullable();
            $table->boolean('active')->default(0);

            $table->foreign('test_type_category_id')
                ->references('id')->on('test_type_categories');

            $table->softDeletes();
            $table->timestamps();
        });

        /*
         * @system blis.v3 defined
         */

        Schema::create('test_type_measures', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('test_type_id')->unsigned();
            $table->integer('measure_id')->unsigned();

            $table->foreign('test_type_id')->references('id')->on('test_types');
            $table->foreign('measure_id')->references('id')->on('measures');
            $table->unique(['test_type_id', 'measure_id']);
        });

        /*
         * @system blis.v3 defined
         */
        Schema::create('test_type_mappings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('code_id')->unsigned()->nullable();
            $table->integer('test_type_id')->unsigned();
            $table->integer('specimen_type_id')->unsigned();
            $table->timestamps();

            $table->foreign('code_id')->references('id')->on('codes');
            $table->foreign('test_type_id')->references('id')->on('test_types');
            $table->foreign('specimen_type_id')->references('id')->on('specimen_types');
            $table->unique(['test_type_id', 'specimen_type_id']);
        });

        /*
         * @system blis.v3 defined
         * @name pre-analytic|analytic|post-analytic
         */
        Schema::create('test_phases', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 45);
            $table->string('display', 45);
        });

        /*
         * @system blis.v3 defined
         */
        Schema::create('test_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 45);
            $table->string('name', 45);
            $table->integer('test_phase_id')->unsigned();

            $table->foreign('test_phase_id')->references('id')->on('test_phases');
        });

        /*
         * @system blis.v3 defined
         */
        Schema::create('control_test_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 45);
            $table->string('name', 45);
        });

        /*
         * @system https://www.hl7.org/fhir/specimen.html
         * @name available|unavailable|unsatisfactory|entered-in-error
         */
        Schema::create('specimen_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 45);
        });
        /*
         * @system blis.v3 defined
         * @example wards|clinics|healthunits
         */
        Schema::create('locations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('identifier', 45)->nullable();
            $table->string('name', 100);
        });

        /*
         * @system blis.v3 defined
         */
        Schema::create('encounter_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 20)->nullable();
            $table->string('display', 45);
        });

        /*
         * @system fhir
         * @name inpatient|outpatient|ambulatory|emergency
         */
        Schema::create('encounter_classes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 20)->nullable();
            $table->string('display', 45);
        });

        /*
         * @system https://www.hl7.org/fhir/encounter.html
         * @identifier Identifier(s) by which this encounter is known
         * @encounter_class_id inpatient|outpatient|ambulatory|emergency
         * @encounter_status_id planned|arrived|triaged|in-progress|onleave|finished|cancelled
         */
        Schema::create('encounters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('identifier')->nullable();
            $table->integer('patient_id')->unsigned();
            $table->integer('location_id')->nullable();
            $table->integer('encounter_class_id')->unsigned()->nullable();
            $table->integer('encounter_status_id')->unsigned()->nullable();
            $table->string('bed_no')->nullable();
            $table->string('practitioner_name')->nullable();
            $table->string('practitioner_contact')->nullable();
            $table->string('practitioner_organisation')->nullable();

            $table->foreign('patient_id')->references('id')->on('patients');
            $table->foreign('encounter_class_id')->references('id')->on('encounter_classes');
            $table->foreign('encounter_status_id')
                ->references('id')->on('encounter_statuses');
            $table->timestamps();
        });

        /*
         * @system blis.v3 defined
         */
        Schema::create('rejection_reasons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('display', 100);
            $table->softDeletes();
        });

        /*
         * @system blis.v3 defined
         */
        Schema::create('referral_reasons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('display', 100);
            $table->softDeletes();
        });

        /*
         * @system blis.v3 defined
         */
        Schema::create('referrals', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('time_dispatched_to')->nullable();
            $table->timestamp('time_dispatched_from')->nullable();
            $table->timestamp('time_receiveded_from')->nullable();
            $table->integer('specimen_id')->unsigned();
            $table->integer('referred_from')->unsigned()->nullable();
            $table->integer('referred_to')->unsigned()->nullable();
            $table->integer('user_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users');

            $table->timestamps();
        });

        /*
         * Create table for associating referral_reasons to referrals (Many-to-Many)
         */
        Schema::create('reason_referral', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('referral_id')->unsigned();
            $table->integer('referral_reason_id')->unsigned();

            $table->foreign('referral_id')->references('id')->on('referrals')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('referral_reason_id')->references('id')->on('referral_reasons')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        /*
         * @system blis.v3 defined
         * @specimen_status_id available|unavailable|unsatisfactory|entered-in-error
         * @identifier External Identifier
         * @accession_identifier Identifier assigned by the lab
         * @parent_id Specimen from which this specimen originated
         */
        Schema::create('specimens', function (Blueprint $table) {
            $table->increments('id');
            $table->string('identifier')->nullable();
            $table->string('accession_identifier')->nullable();
            $table->integer('specimen_type_id')->unsigned();
            $table->integer('parent_id')->unsigned()->nullable();
            $table->integer('specimen_status_id')->unsigned()->default(\App\Models\SpecimenStatus::received);
            $table->integer('received_by')->unsigned();
            $table->string('collected_by')->nullable();
            $table->timestamp('time_collected')->nullable();
            $table->timestamp('time_received')->nullable();

            $table->foreign('specimen_type_id')->references('id')->on('specimen_types');
            $table->foreign('specimen_status_id')->references('id')->on('specimen_statuses');
            $table->foreign('received_by')->references('id')->on('users');
        });

        /*
         * @system blis.v3 defined
         * @identifier Unique ID for external records
         */
        Schema::create('tests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('encounter_id')->unsigned();
            $table->string('identifier')->nullable();
            $table->integer('test_type_id')->unsigned();
            $table->integer('specimen_id')->unsigned()->nullable();
            $table->integer('test_status_id')->unsigned()->default(\App\Models\TestStatus::pending);
            $table->uuid('created_by')->nullable();
            $table->integer('tested_by')->unsigned()->nullable();
            $table->integer('verified_by')->unsigned()->nullable();
            $table->string('requested_by', 60);
            $table->timestamp('time_started')->nullable();
            $table->timestamp('time_completed')->nullable();
            $table->timestamp('time_verified')->nullable();
            $table->timestamps();

            $table->index('created_by');
            $table->index('tested_by');
            $table->index('verified_by');
            $table->foreign('encounter_id')->references('id')->on('encounters');
            $table->foreign('test_type_id')->references('id')->on('test_types');
            $table->foreign('specimen_id')->references('id')->on('specimens');
            $table->foreign('test_status_id')->references('id')->on('test_statuses');
        });

        /*
         * @system blis.v3 defined
         * @test_id entered if test phase is analytic phase
         */
        Schema::create('specimen_rejections', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('specimen_id')->unsigned();
            $table->integer('test_phase_id')->unsigned();// identifies whether its preanalytic or analytic rejection
            $table->integer('test_id')->unsigned()->nullable();// applicable only for analytic
            $table->integer('authorized_person_informed')->unsigned()->nullable();
            $table->integer('rejected_by')->unsigned();
            $table->timestamp('time_rejected');

            $table->index('rejected_by');
            $table->foreign('test_id')->references('id')->on('tests');
            $table->foreign('test_phase_id')->references('id')->on('test_phases');
            $table->foreign('specimen_id')->references('id')->on('specimens');
        });

        /*
         * Create table for associating rejection_reasons to specimen_rejections (Many-to-Many)
         */
        Schema::create('reason_specimen_rejection', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('specimen_rejection_id')->unsigned();
            $table->integer('rejection_reason_id')->unsigned();

            $table->foreign('specimen_rejection_id')->references('id')->on('specimen_rejections')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('rejection_reason_id')->references('id')->on('rejection_reasons')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        /*
         * @system blis.v3 defined
         * @description isolated organisms and gram results also listed
         */
        Schema::create('results', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('test_id')->unsigned();
            $table->integer('measure_id')->unsigned();
            $table->string('result')->nullable();
            $table->integer('measure_range_id')->unsigned()->nullable();
            $table->timestamp('time_entered')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('test_id')->references('id')->on('tests');
            $table->foreign('measure_id')->references('id')->on('measures');
            $table->unique(['test_id', 'measure_id', 'measure_range_id']);
        });

        /*
         * @system blis.v3 defined
         */
        Schema::create('antibiotics', function ($table) {
            $table->increments('id');
            $table->string('code')->nullable();
            $table->string('name');
        });

        /*
         * @system blis.v3 defined
         * @description used for both isolated organisms and gram stain culture
         */
        Schema::create('antibiotic_susceptibilities', function (Blueprint $table) {
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

        /*
         * @system blis.v3 defined
         * @description used for both isolated organisms and gram stain
         */
        Schema::create('susceptibility_break_points', function ($table) {
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

        /*
         * @system blis.v3 defined
         * @description incrementing and resetting patient accession_identifier
         */
        Schema::create('counter', function (Blueprint $table) {
            $table->increments('id');
        });

        Schema::create('instruments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100)->unique();
            $table->string('ip', 100)->nullable();
            $table->string('hostname', 100)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('lots', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number', 100)->unique();
            $table->string('description', 400)->nullable();
            $table->date('expiry');
            $table->integer('instrument_id')->unsigned()->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('control_tests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('lot_id')->unsigned();
            $table->integer('tested_by')->unsigned()->nullable();
            $table->integer('test_type_id')->unsigned();
            $table->integer('control_test_status_id')->unsigned()->default(\App\Models\ControlTestStatus::pending);
            $table->timestamp('time_started')->nullable();
            $table->timestamp('time_completed')->nullable();
            $table->timestamp('time_verified')->nullable();

            $table->foreign('test_type_id')->references('id')->on('test_types');
            $table->foreign('lot_id')->references('id')->on('lots');
            $table->foreign('control_test_status_id')->references('id')->on('control_test_statuses');
            $table->timestamps();
        });

        Schema::create('control_results', function (Blueprint $table) {
            $table->increments('id');
            $table->string('result')->nullable();
            $table->integer('measure_id')->unsigned();
            $table->integer('control_test_id')->unsigned();
            $table->integer('measure_range_id')->unsigned()->nullable();

            $table->foreign('control_test_id')->references('id')->on('control_tests');
            $table->foreign('measure_id')->references('id')->on('measures');
// introduce restriction rename control_test to control and check if its not too long????
// $table->unique(['control_id', 'measure_id', 'measure_range_id']);

            $table->timestamps();
        });

        Eloquent::unguard();

        //Super Admin
        $superUser = \App\User::create([
            'name' => 'BLIS Super Admin',
            'username' => 'admin@blis.local',
            'email' => 'admin@blis.local',
            'password' =>  bcrypt('password'),
        ]);

        /* Measure Types */
        $measureTypes = [
            [
                'id' => '1',
                'code' => 'numeric',
                'name' => 'Numeric'
            ],
            [
                'id' => '2',
                'code' => 'alphanumeric',
                'name' => 'Alphanumeric'
            ],
            [
                'id' => '3',
                'code' => 'multi_alphanumeric',
                'name' => 'Multi Alphanumeric'
            ],
            [
                'id' => '4',
                'code' => 'free_text',
                'name' => 'Free Text'
            ],
        ];

        foreach ($measureTypes as $measureType) {
            \App\Models\MeasureType::create($measureType);
        }

        /* Test Phase table */
        $test_phases = [
            [
                'id' => '1',
                'code' => 'pre_analytical',
                'display' => 'Pre Analytical',
            ],
            [
                'id' => '2',
                'code' => 'analytical',
                'display' => 'Analytical',
            ],
            [
                'id' => '3',
                'code' => 'post_analytical',
                'display' => 'Post Analytical',
            ],
        ];
        foreach ($test_phases as $test_phase) {
            \App\Models\TestPhase::create($test_phase);
        }

        /* Test Status table */
        $test_statuses = [
          ['id' => '1', 'code' => 'pending', 'name' => 'Pending', 'test_phase_id' => '1'], //PreAnalytical
          ['id' => '2', 'code' => 'started', 'name' => 'Started', 'test_phase_id' => '2'], //Analytical
          ['id' => '3', 'code' => 'completed', 'name' => 'Completed', 'test_phase_id' => '3'], //PostAnalytical
          ['id' => '4', 'code' => 'verified', 'name' => 'Verified', 'test_phase_id' => '3'], //PostAnalytical
        ];
        foreach ($test_statuses as $test_status) {
            \App\Models\TestStatus::create($test_status);
        }

        /* Control Test Status table */
        $control_test_statuses = [
          ['id' => '1', 'code' => 'pending', 'name' => 'Pending'],
          ['id' => '2', 'code' => 'completed', 'name' => 'Completed'],
        ];
        foreach ($control_test_statuses as $control_test_status) {
            \App\Models\ControlTestStatus::create($control_test_status);
        }

        /* Specimen Status table */
        $specimen_statuses = [
          ['id' => '1', 'name' => 'Pending'],// mostly redandant status, only if implementation is requested
          ['id' => '2', 'name' => 'Received'],
          ['id' => '3', 'name' => 'Rejected'],
        ];
        foreach ($specimen_statuses as $specimen_status) {
            \App\Models\SpecimenStatus::create($specimen_status);
        }

        \App\Models\SusceptibilityRange::create([
            'code' => 'S',
            'name'=>'Sensitive',
        ]);
        \App\Models\SusceptibilityRange::create([
            'code' => 'I',
            'name'=>'Intermediate',
        ]);
        \App\Models\SusceptibilityRange::create([
            'code' => 'R',
            'name'=>'Resistant',
        ]);

        /* gender table */
        $genders = [
          ['id' => '1', 'code' => 'male', 'display' => 'Male'],
          ['id' => '2', 'code' => 'female', 'display' => 'Female'],
          ['id' => '3', 'code' => 'both', 'display' => 'Both'],
          ['id' => '4', 'code' => 'unknown', 'display' => 'Unknown'],
        ];
        foreach ($genders as $gender) {
            \App\Models\Gender::create($gender);
        }

        /* encounter class table */
        $encounterClasses = [
          ['id' => '1', 'code' => 'inpatient', 'display' => 'In Patient'],
          ['id' => '2', 'code' => 'outpatient', 'display' => 'Out Patient'],
        ];
        foreach ($encounterClasses as $encounterClass) {
            \App\Models\EncounterClass::create($encounterClass);
        }

        /* Permissions table */
        $permissions = [
            // system configurations
            ['name' => 'manage_configurations', 'display_name' => 'Can manage configurations'],

            // manage test menu
            ['name' => 'manage_test_catalog', 'display_name' => 'Can manage test catalog'],

            // user management
            ['name' => 'manage_users', 'display_name' => 'Can manage users'],

            // patient data management
            ['name' => 'manage_patients', 'display_name' => 'Can add patients'],
            ['name' => 'view_patient_names', 'display_name' => 'Can view patient names'],

            // routine and reference testing
            ['name' => 'request_test', 'display_name' => 'Can request new test'], // includes external systems
            ['name' => 'accept_test_specimen', 'display_name' => 'Can accept test specimen'],
            ['name' => 'reject_test_specimen', 'display_name' => 'Can reject test specimen'],
            ['name' => 'change_test_specimen', 'display_name' => 'Can change test specimen'],
            ['name' => 'start_test', 'display_name' => 'Can start tests'],
            ['name' => 'enter_test_result', 'display_name' => 'Can enter tests results'],
            ['name' => 'edit_test_result', 'display_name' => 'Can edit test results'],
            ['name' => 'verify_test_result', 'display_name' => 'Can verify test results'],
            ['name' => 'refer_test_specimen', 'display_name' => 'Can refer specimens'],
            ['name' => 'manage_quality_control', 'display_name' => 'Can manage Quality Control'],

            // reporting
            ['name' => 'view_reports', 'display_name' => 'Can view reports'],

            // inventory and equipment
            ['name' => 'manage_inventory', 'display_name' => 'Can manage inventory'],
            ['name' => 'request_topup', 'display_name' => 'Can request top-up'],
            ['name' => 'manage_equipment', 'display_name' => 'Can manage equipment'],

            // biosafty and biosecurity
            ['name' => 'manage_biosafty_biosecurity', 'display_name' => 'Can manage biosafty-biosecurity'],

            // inventory
            ['name' => 'manage_blood_bank', 'display_name' => 'Can manage blood bank'],
            ['name' => 'view_blood_bank', 'display_name' => 'Can view blood bank'],
        ];

        foreach ($permissions as $permission) {
            \App\Models\Permission::create($permission);
        }

        /* Roles table */
        $superRole = \App\Models\Role::create(['name' => 'Superadmin']);

        \App\Models\Role::create(['name' => 'Technologist']);
        \App\Models\Role::create(['name' => 'Receptionist']);


        $superUser = \App\User::find($superUser->id);
        $permissions = \App\Models\Permission::all();

        //Assign all permissions to role Superadmin
        foreach ($permissions as $permission) {
            $superRole->attachPermission($permission);
        }
        //Assign role Superadmin to user_id=1
        $superUser->attachRole($superRole);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('control_results');
        Schema::dropIfExists('control_tests');
        Schema::dropIfExists('control_measure_ranges');
        Schema::dropIfExists('control_measures');
        Schema::dropIfExists('control_types');
        Schema::dropIfExists('lots');
        Schema::dropIfExists('instruments');
        Schema::dropIfExists('counter');
        Schema::dropIfExists('adhoc_options');
        Schema::dropIfExists('adhoc_categories');
        Schema::dropIfExists('susceptibility_break_points');
        Schema::dropIfExists('antibiotic_susceptibilities');
        Schema::dropIfExists('antibiotics');
        Schema::dropIfExists('results');
        Schema::dropIfExists('specimen_rejections');
        Schema::dropIfExists('specimen_type_test_type');
        Schema::dropIfExists('tests');
        Schema::dropIfExists('specimens');
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
        Schema::dropIfExists('test_mappings');
        Schema::dropIfExists('test_type_measures');
        Schema::dropIfExists('test_types');
        Schema::dropIfExists('susceptibility_ranges');
        Schema::dropIfExists('measure_ranges');
        Schema::dropIfExists('interpretations');
        Schema::dropIfExists('measures');
        Schema::dropIfExists('measure_types');
        Schema::dropIfExists('test_type_categories');
        Schema::dropIfExists('specimen_types');
        Schema::dropIfExists('patients');
        Schema::dropIfExists('genders');
        Schema::dropIfExists('organizations');
        Schema::dropIfExists('names');
        Schema::dropIfExists('codes');
        Schema::dropIfExists('code_systems');
        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('roles');
    }
}
