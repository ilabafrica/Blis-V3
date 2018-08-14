<?php

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->word,
        'username' => $faker->userName,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Location::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
    ];
});

$factory->define(\App\Models\Name::class, function (Faker\Generator $faker) {
    return [
        'use' => $faker->word,
        'text' => $faker->word,
        'family' => $faker->word,
        'given' => $faker->word,
        'prefix' => $faker->word,
        'suffix' => $faker->word,
    ];
});

$factory->define(\App\Models\Patient::class, function (Faker\Generator $faker) {
    return [
        'created_by' => \App\User::inRandomOrder()->first()->id,
        'identifier' => $faker->unique()->safeEmail,
        'name_id' => factory(\App\Models\Name::class)->create()->id,
        'gender_id' => rand(1,2),
        'birth_date' => \Faker\Factory::create()->date(),
        'marital_status' => $faker->word,// todo: create something relevant
        'created_at' => date('Y-m-d H:i:s',strtotime("-10 days"))
    ];
});

$factory->define(\App\Models\Encounter::class, function (Faker\Generator $faker) {
    return [
        'identifier' => $faker->word,
        'patient_id' => factory(\App\Models\Patient::class)->create()->id,
        'location_id' => \App\Models\Location::inRandomOrder()->first()->id,
        'encounter_class_id' => \App\Models\EncounterClass::outpatient,
        'encounter_status_id' => null,
        'bed_no' => $faker->word,
        'practitioner_name' => $faker->word,
        'practitioner_contact' => $faker->word,
        'practitioner_organisation' => $faker->word,
    ];
});

$factory->define(\App\Models\Specimen::class, function (Faker\Generator $faker) {
    $userId = \App\User::inRandomOrder()->first()->id;

    return [
        'identifier' => $faker->word,
        'accession_identifier' => $faker->word,
        'specimen_type_id' => null,
        'received_by' => $userId,
        'collected_by' => $userId,
    ];
});

$factory->define(\App\Models\Test::class, function (Faker\Generator $faker) {
    $testTypeId = \App\Models\TestType::inRandomOrder()->first()->id;
    $user_id = \App\User::inRandomOrder()->first()->id;
    $specimenTypeId = \App\Models\TestTypeMapping::where('test_type_id',$testTypeId)->first()->specimen_type_id;
    $specimen = factory(App\Models\Specimen::class)->create([
        'specimen_type_id' => $specimenTypeId,
    ]);
    $test_status = rand(1,4);
    $created_at = date('Y-m-d H:i:s',strtotime("-".rand(0,10)." days"));
    switch ($test_status) {
        case 1: //pending
            $tested_by = NULL;
            $verified_by = NULL;
            $time_started = NULL;
            $specimen_id = NULL;
            $time_completed = NULL;
            $time_verified = NULL;
            break;
        
        case 2: //started
            $tested_by = NULL;
            $verified_by = NULL;
            $time_started = date('Y-m-d H:i:s',strtotime($created_at."+".rand(20,1800)." minutes"));
            $specimen_id = $specimen->id;
            $time_completed = NULL;
            $time_verified = NULL;
            break;
        
        case 3: //completed
            $tested_by = \App\User::inRandomOrder()->first()->id;
            $verified_by = NULL;
            $time_started = date($created_at,strtotime("+".rand(20,1800)." minutes"));
            $specimen_id = $specimen->id;
            $time_completed = date('Y-m-d H:i:s',strtotime($time_started."+".rand(10,3600)." minutes"));
            $time_verified = NULL;
            break;
        
        case 4: //verified
            $tested_by = \App\User::inRandomOrder()->first()->id;
            $verified_by = \App\User::where("id","!=",$tested_by)->inRandomOrder()->first()->id;
            $time_started = date('Y-m-d H:i:s',strtotime($created_at."+".rand(20,1800)." minutes"));
            $specimen_id = $specimen->id;
            $time_completed = date('Y-m-d H:i:s',strtotime($time_started."+".rand(20,3600)." minutes"));
            $time_verified = date('Y-m-d H:i:s',strtotime($time_completed."+".rand(5,3600)." minutes"));;
            break;
        
        default:
            $tested_by = NULL;
            $verified_by = NULL;
            $time_started = NULL;
            $specimen_id = NULL;
            $time_completed = NULL;
            $time_verified = NULL;            
            break;
    }

    return [
        'encounter_id' => factory(\App\Models\Encounter::class)->create()->id,
        'identifier' => $faker->word,
        'test_type_id' => $testTypeId,
        'specimen_id' => $specimen_id,
        'test_status_id' => $test_status,
        'created_by' => $user_id,
        'tested_by' => $tested_by,
        'verified_by' => $verified_by,
        'requested_by' => $faker->word,
        'time_started' => $time_started,
        'time_completed' => $time_completed,
        'time_verified' => $time_verified,
        'created_at' => $created_at,
        'time_sent' => date('Y-m-d H:i:s'),
    ];
});

$factory->define(\App\Models\Result::class, function (Faker\Generator $faker) {
    return [
        'test_id' => NULL,// must be passed
        'measure_id' => NULL,// must be passed
        'result' => $faker->word,
        'measure_range_id' => NULL,// must be passed
        'time_entered' => date('Y-m-d H:i:s'),
    ];
});

// caters for facilities
$factory->define(\App\Models\Organization::class, function (Faker\Generator $faker) {
    return [
        'created_by' => factory(\App\User::class)->create()->id,
        'name' => $faker->word,
        'alias' => $faker->word,
        'telecom' => $faker->randomNumber(),
        'address' => $faker->randomNumber(),
        'part_of' => $faker->randomNumber(),
        'end_point' => $faker->word,
    ];
});