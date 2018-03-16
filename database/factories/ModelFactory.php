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

$factory->define(\App\Models\Gender::class, function (Faker\Generator $faker) {
    return [
        'code' => 'male',
        'display' => 'Male',
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

$factory->define(\App\Models\Telecom::class, function (Faker\Generator $faker) {
    return [
        'created_by' => factory(\App\User::class)->create()->id,
        'system' => $faker->word,
        'value' => $faker->word,
    ];
});

$factory->define(\App\Models\Address::class, function (Faker\Generator $faker) {
    return [
        'patient_id' => $faker->randomNumber(),
        'text' => $faker->word,
        'line' => $faker->word,
        'city' => $faker->city,
        'district' => $faker->word,
        'state' => $faker->word,
        'postal_code' => $faker->word,
        'country' => $faker->country,
        'period' => $faker->date(),
    ];
});

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

$factory->define(\App\Models\MaritalStatus::class, function (Faker\Generator $faker) {
    return [
        'code' => 'Annuled',
        'display' => $faker->word,
        'definition' => $faker->word,
    ];
});

$factory->define(\App\Models\Patient::class, function (Faker\Generator $faker) {
    $userId = factory(\App\User::class)->create()->id;

    return [
        'created_by' => $userId,
        'identifier' => $faker->unique()->safeEmail,
        'name_id' => factory(\App\Models\Name::class)->create()->id,
        'gender_id' => factory(\App\Models\Gender::class)->create()->id,
        'birth_date' => \Faker\Factory::create()->date(),
        'marital_status' => factory(\App\Models\MaritalStatus::class)->create()->id,
    ];
});

$factory->define(\App\Models\Practitioner::class, function (Faker\Generator $faker) {
    $userId = factory(\App\User::class)->create()->id;

    return [
        'created_by' => $userId,
        'name' => factory(\App\Models\Name::class)->create()->id,
        'telecom' => factory(\App\Models\ContactPoint::class)->create(['created_by'=>$userId])->id,
        'gender_id' => factory(\App\Models\Gender::class)->create()->id,
        'birth_date' => \Faker\Factory::create()->date(),
        'address' => factory(\App\Models\Address::class)->create()->id,
    ];
});

$factory->define(App\Models\StatusHistory::class, function (Faker\Generator $faker) {
    return [
        'code' => $faker->randomNumber(),
        'episode_of_care_id' => $faker->randomNumber(),
    ];
});

$factory->define(App\Models\Coding::class, function (Faker\Generator $faker) {
    return [
    ];
});

$factory->define(App\Models\EpisodeofCare::class, function (Faker\Generator $faker) {
    return [
        'status' => $faker->randomNumber(),
        'type' => $faker->randomNumber(),
        'patient' => $faker->randomNumber(),
        'organization_id' => $faker->randomNumber(),
        'period' => $faker->randomNumber(),
        'practitioners_id' => $faker->randomNumber(),
        'team_id' => $faker->randomNumber(),
    ];
});


$factory->define(App\Models\Collection::class, function (Faker\Generator $faker) {
    return [
        'collector' => $faker->randomNumber(),
        'collection_time' => $faker->dateTimeBetween(),
        'quantity_id' => $faker->randomNumber(),
        'method' => $faker->randomNumber(),
        'body_site' => $faker->randomNumber(),
    ];
});

$factory->define(App\Models\PatientContact::class, function (Faker\Generator $faker) {
    return [
        'patient_id' => $faker->randomNumber(),
        'relationship' => $faker->randomNumber(),
        'name' => $faker->name,
        'telecom' => $faker->randomNumber(),
        'gender' => $faker->randomNumber(),
        'organization_id' => $faker->randomNumber(),
        'period' => $faker->date(),
    ];
});

$factory->define(App\Models\Specimen::class, function (Faker\Generator $faker) {
    return [
        'accession_identifier' => $faker->randomNumber(),
        'status' => $faker->randomNumber(),
        'type' => $faker->randomNumber(),
        'subject' => $faker->randomNumber(),
        'received_time' => $faker->dateTimeBetween(),
        'parent' => $faker->randomNumber(),
        'note' => $faker->word,
    ];
});

$factory->define(App\Models\Substance::class, function (Faker\Generator $faker) {
    return [
        'status' => $faker->randomNumber(),
        'category' => $faker->randomNumber(),
        'code' => $faker->randomNumber(),
        'description' => $faker->word,
    ];
});
$factory->define(App\Models\CareTeam::class, function (Faker\Generator $faker) {
    return [
        'identifiers' => $faker->word,
        'status_id' => $faker->randomNumber(),
        'category' => $faker->randomNumber(),
        'name' => $faker->name,
        'subject' => $faker->randomNumber(),
        'context' => $faker->randomNumber(),
        'period' => $faker->randomNumber(),
        'reason_code' => $faker->randomNumber(),
        'reason_reference' => $faker->word,
        'organization_id' => $faker->randomNumber(),
        'comment' => $faker->word,
    ];
});
