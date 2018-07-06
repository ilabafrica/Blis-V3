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



$factory->define(App\Models\StatusHistory::class, function (Faker\Generator $faker) {
    return [
        'code' => $faker->randomNumber(),
        'episode_of_care_id' => $faker->randomNumber(),
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
