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
        'gender_id' => \App\Models\Gender::inRandomOrder()->first()->id,
        'birth_date' => \Faker\Factory::create()->date(),
        'marital_status' => $faker->word,// todo: create something relevant
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
    $userId = \App\User::inRandomOrder()->first()->id;
    $specimenTypeId = \App\Models\TestTypeMapping::where('test_type_id',$testTypeId)->first()->specimen_type_id;
    $specimen = factory(App\Models\Specimen::class)->make([
        'specimen_type_id' => $specimenTypeId,
    ]);


    return [
        'encounter_id' => factory(\App\Models\Encounter::class)->create()->id,
        'identifier' => $faker->word,
        'test_type_id' => $testTypeId,
        'specimen_id' => $specimen->id,
        'test_status_id' => \App\Models\TestStatus::completed,// todo: create the others as well, start with this one
        'tested_by' => $userId,
        'verified_by' => $userId,
        'requested_by' => $faker->word,
        'time_started' => date('Y-m-d H:i:s'),// todo: reduce time now some how
        'time_completed' => date('Y-m-d H:i:s'),
        'time_verified' => date('Y-m-d H:i:s'),
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