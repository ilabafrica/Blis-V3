<?php
$factory->define(App\Models\PanelType::class, function (Faker\Generator $faker) {
	return [
		'code_id' => $faker->randomNumber(),
		'status_id' => $faker->randomNumber(),
		'category_id' => $faker->randomNumber(),
		'deleted_at' => $faker->dateTimeBetween(),
	];
});

$factory->define(App\Models\Panel::class, function (Faker\Generator $faker) {
	return [
		'panel_type_id' = factory(\App\Models\PanelType::class)->create()->id,
		'performed_by' = factory(\App\User::class)->create()->id,
		'specimen_id' = factory(\App\Models\Specimen::class)->create()->id,
		'conclusion' = $faker->word(),
		'coded_diagnosis_id' = factory(\App\Models\CodeableConcept::class)->create()->id,
		'status_id' = factory(\App\Models\CodeableConcept::class)->create()->id,
		'sort_order' = $faker->randomNumber(3)
	];
});

$factory->define(App\Models\ObservationTypes::class, function (Faker\Generator $faker) {
	return [
		'status_id' => $faker->randomNumber(),
		'category_id' => $faker->randomNumber(),
		'code_id' => $faker->randomNumber(),
		'result_type' => $faker->randomNumber(),
		'sort_order' => $faker->randomNumber(),
		'deleted_at' => $faker->dateTimeBetween(),
	];
});

$factory->define(App\Models\Observation::class, function (Faker\Generator $faker) {
	return [
		'status_id' => $faker->randomNumber(),
		'category_id' => $faker->randomNumber(),
		'panel_id' => $faker->randomNumber(),
		'user_id' => $faker->randomNumber(),
		'quantity_id' => $faker->randomNumber(),
		'data_absent_reason' => $faker->randomNumber(),
		'interpretation' => $faker->randomNumber(),
		'comment' => $faker->word,
		'issued' => $faker->date(),
		'deleted_at' => $faker->dateTimeBetween(),
	];
});

$factory->define(App\Models\ComponentsTypes::class, function (Faker\Generator $faker) {
	return [
		'code_id' => $faker->randomNumber(),
		'result_type_id' => $faker->randomNumber(),
		'reference_range_id' => $faker->randomNumber(),
		'parent_id' => $faker->randomNumber(),
	];
});

$factory->define(App\Models\Components::class, function (Faker\Generator $faker) {
	return [
		'observation_id' => $faker->randomNumber(),
		'performed_by' => $faker->randomNumber(),
		'result' => $faker->word,
		'data_absent_reason' => $faker->randomNumber(),
		'interpretation' => $faker->randomNumber(),
		'deleted_at' => $faker->dateTimeBetween(),
	];
});

$factory->define(App\Models\ReferenceRange::class, function (Faker\Generator $faker) {
	return [
		'low_normal' => $faker->randomFloat(),
		'high_normal' => $faker->randomFloat(),
		'low_critical' => $faker->randomFloat(),
		'high_critical' => $faker->randomFloat(),
		'age_min' => $faker->randomNumber(),
		'age_max' => $faker->randomNumber(),
		'age_type' => $faker->randomNumber(),
		'applies_to' => $faker->randomNumber(),
		'text' => $faker->word,
		'deleted_at' => $faker->dateTimeBetween(),
	];
});
