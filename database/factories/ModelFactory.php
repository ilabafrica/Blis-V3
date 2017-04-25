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


$factory->define(\App\DB\HumanName::class, function (Faker\Generator $faker) {

    return [
        'user_id' => factory(\App\User::class)->create()->id,
        'use' => $faker->randomElement(['usual', 'official', 'temp', 'nickname', 'anonymous', 'old', 'maiden']),
        'text' => $faker->word
    ];
});


$factory->define(\App\DB\ContactPoint::class, function (Faker\Generator $faker) {

    return [
        'user_id' => factory(\App\User::class)->create()->id,
        'system' => $faker->randomElement(['phone', 'fax', 'email', 'pager', 'url', 'sms', 'other']),
        'value' => $faker->word,
        'use' => $faker->randomElement(['home', 'work', 'temp', 'old', 'mobile'])
    ];
});

$factory->define(\App\DB\Address::class, function (Faker\Generator $faker) {

    return [
        'use' => $faker->randomElement(['home', 'work', 'temp', 'old']),
        'type' => $faker->randomElement(['postal', 'physical', 'both']),
        'test' => $faker->word,
    ];
});

$factory->define(\App\DB\Organization::class, function (Faker\Generator $faker) {

    return [
        'type' => $faker->randomElement([
            'healthcare_provider',
            'hospital_department',
            'organizational_team',
            'government',
            'insurance_company',
            'educational_institute',
            'religious_institution',
            'clinical_research_sponsor',
            'community_group',
            'corporation',
            'other'
        ]),
        'name' => $faker->word,
    ];
});


$factory->define(\App\DB\Patient::class, function (Faker\Generator $faker) {
    
    $userId  = factory(User::class)->create()->id;

    return [
        'user_id' => $userId,
        'name' => factory(\App\DB\HumanName::class)->create(['user_id'=>$userId])->id,
        'telecom' => factory(\App\DB\ContactPoint::class)->create(['user_id'=>$userId])->id,
        'gender' => \Faker\Factory::create()->randomElement(['male', 'female', 'other', 'unknown']),
        'birth_date' => \Faker\Factory::create()->date(),
        'address' => factory(\App\DB\Address::class)->create(['user_id'=>$userId])->id,
        'marital_status' => \Faker\Factory::create()->randomElement([
            'annulled',
            'divorced',
            'interlocutory',
            'legally_separated',
            'married',
            'polygamous',
            'never_married',
            'domestic_partner',
            'unmarried',
            'widowed',
            'unknown'
        ]),
    ];
});

$factory->define(\App\DB\Practitioner::class, function (Faker\Generator $faker) {

    $userId  = factory(User::class)->create()->id;

    return [
        'user_id' => $userId,
        'name' => factory(\App\DB\HumanName::class)->create(['user_id'=>$userId])->id,
        'telecom' => factory(\App\DB\ContactPoint::class)->create(['user_id'=>$userId])->id,
        'gender' => \Faker\Factory::create()->randomElement(['male', 'female', 'other', 'unknown']),
        'birth_date' => \Faker\Factory::create()->date(),
        'address' => factory(\App\DB\Address::class)->create(['user_id'=>$userId])->id
    ];
});

