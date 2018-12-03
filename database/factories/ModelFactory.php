<?php

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->word,
        'username' => $faker->userName,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'created_at' => date('Y-m-d H:i:s', strtotime('-10 days')),
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
        'gender_id' => rand(1, 2),
        'birth_date' => \Faker\Factory::create()->date(),
        'marital_status' => $faker->word, // todo: create something relevant
        'created_at' => date('Y-m-d H:i:s', strtotime('-10 days')),
    ];
});

$factory->define(\App\Models\TestTypeCategory::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
    ];
});

$factory->define(\App\Models\TestType::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->word,
        'culture' => 0,
        'test_type_category_id' => factory(\App\Models\TestTypeCategory::class)->create()->id,
    ];
});

$factory->define(\App\Models\Encounter::class, function (Faker\Generator $faker) {
    return [
        'identifier' => $faker->word,
        'patient_id' => factory(\App\Models\Patient::class)->create()->id,
        'location_id' => factory(\App\Models\Location::class)->create()->id,
        'encounter_class_id' => \App\Models\EncounterClass::outpatient,
        'encounter_status_id' => null,
        'bed_no' => $faker->word,
        'practitioner_name' => $faker->word,
        'practitioner_contact' => $faker->word,
        'practitioner_organisation' => $faker->word,
    ];
});

$factory->define(\App\Models\SpecimenType::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
    ];
});

$factory->define(\App\Models\Specimen::class, function (Faker\Generator $faker) {
    $userId = \App\User::inRandomOrder()->first()->id;
    $collected_at = date('Y-m-d H:i:s', strtotime('-'.rand(0, 10).' days'));
    $received_at = date('Y-m-d H:i:s', strtotime($collected_at.'+'.rand(20, 900).' minutes'));

    return [
        'identifier' => $faker->word,
        'accession_identifier' => $faker->word,
        'specimen_type_id' => \App\Models\SpecimenType::inRandomOrder()->first()->id,
        'received_by' => $userId,
        'collected_by' => $userId,
        'time_collected' => $collected_at,
        'time_received' => $received_at,

    ];
});

$factory->define(\App\Models\Measure::class, function (Faker\Generator $faker) {
    return [
        'test_type_id' => null,
        'measure_type_id' => null,
        'name' => $faker->word,
    ];
});

$factory->define(\App\Models\Test::class, function (Faker\Generator $faker) {
    return [
        'encounter_id' => factory(\App\Models\Encounter::class)->create([
            'patient_id' => \App\Models\Patient::inRandomOrder()->first()->id,
            'location_id' => \App\Models\Location::inRandomOrder()->first()->id,
        ])->id,
        'identifier' => $faker->word,
        'test_type_id' => null,
        'specimen_id' => null,
        'test_status_id' => null,
        'created_by' => null,
        'tested_by' => null,
        'verified_by' => null,
        'requested_by' => $faker->word,
        'time_started' => date('Y-m-d H:i:s'),
        'time_completed' => date('Y-m-d H:i:s'),
        'time_verified' => date('Y-m-d H:i:s'),
        'created_at' => date('Y-m-d H:i:s'),
    ];
});

$factory->define(\App\Models\Result::class, function (Faker\Generator $faker) {
    return [
        'test_id' => null,
        'measure_id' => null,
        'result' => $faker->word,
        'measure_range_id' => null,
        'time_entered' => date('Y-m-d H:i:s'),
    ];
});

$factory->define(\App\Models\Lot::class, function (Faker\Generator $faker) {
    return [
        'number' => $faker->word,
        'description' => $faker->word,
        'expiry' => date('Y-m-d H:i:s'),
        'instrument_id' => null,
    ];
});

$factory->define(\App\Models\ControlTest::class, function (Faker\Generator $faker) {
    return [
        'lot_id' => factory(\App\Models\Lot::class)->create()->id,
        'tested_by' => \App\User::inRandomOrder()->first()->id,
        'test_type_id' => factory(\App\Models\TestType::class)->create()->id,
        'control_test_status_id' => \App\Models\ControlTestStatus::completed,
        'time_started' => date('Y-m-d H:i:s'),
        'time_completed' => date('Y-m-d H:i:s'),
        'time_verified' => date('Y-m-d H:i:s'),
    ];
});

$factory->define(\App\Models\Result::class, function (Faker\Generator $faker) {
    return [
        'test_id' => null,
        'measure_id' => null,
        'result' => $faker->word,
        'measure_range_id' => null,
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

$factory->define(\App\Models\RejectionReason::class, function (Faker\Generator $faker) {
    return [
        'display' => $faker->word,
    ];
});
