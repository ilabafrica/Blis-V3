<?php

$factory->define(App\UserType::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->word,
        'description' => $faker->sentence(),
    ];
});

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'type' => 1,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(\App\Models\CodeableConcept::class, function (Faker\Generator $faker) {

    return [
        'code' => $faker->word,
        'description' => $faker->word
    ];
});

$factory->define(\App\Models\HumanName::class, function (Faker\Generator $faker) {

    return [
        'user_id' => factory(\App\User::class)->create()->id,
        'use' =>factory(\App\Models\CodeableConcept::class)->create()->id,
        'text' => $faker->word
    ];
});


$factory->define(\App\Models\ContactPoint::class, function (Faker\Generator $faker) {

    return [
        'user_id' => factory(\App\User::class)->create()->id,
        'system' => factory(\App\Models\CodeableConcept::class)->create()->id,
        'value' => $faker->word,
        'use' => factory(\App\Models\CodeableConcept::class)->create()->id,
    ];
});

$factory->define(\App\Models\Address::class, function (Faker\Generator $faker) {

    return [
        'use' => factory(\App\Models\CodeableConcept::class)->create()->id,
        'type' => factory(\App\Models\CodeableConcept::class)->create()->id,
        'text' => $faker->word,
    ];
});

$factory->define(\App\Models\Organization::class, function (Faker\Generator $faker) {

    return [
        'user_id' => factory(\App\User::class)->create()->id,
        'type' => factory(\App\Models\CodeableConcept::class)->create()->id,
        'name' => $faker->word,
    ];
});


$factory->define(\App\Models\Patient::class, function (Faker\Generator $faker) {
    
    $userId  = factory(\App\User::class)->create()->id;

    return [
        'user_id' => $userId,
        'name' => factory(\App\Models\HumanName::class)->create(['user_id'=>$userId])->id,
        'gender' => factory(\App\Models\CodeableConcept::class)->create()->id,
        'birth_date' => \Faker\Factory::create()->date(),
        'address' => factory(\App\Models\Address::class)->create()->id,
        'marital_status' => factory(\App\Models\CodeableConcept::class)->create()->id,
    ];
});

$factory->define(\App\Models\Practitioner::class, function (Faker\Generator $faker) {

    $userId  = factory(\App\User::class)->create()->id;

    return [
        'user_id' => $userId,
        'name' => factory(\App\Models\HumanName::class)->create(['user_id'=>$userId])->id,
        'telecom' => factory(\App\Models\ContactPoint::class)->create(['user_id'=>$userId])->id,
        'gender' => factory(\App\Models\CodeableConcept::class)->create()->id,
        'birth_date' => \Faker\Factory::create()->date(),
        'address' => factory(\App\Models\Address::class)->create()->id,
    ];
});

