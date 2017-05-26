<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ObservationTypeTest extends TestCase
{
	use DatabaseMigrations; //Run and drop migrations on all tests

	public function setup(){
		parent::setup();
		$this->setVariables();
	}
	
	public function setVariables()
	{
		$observationTypeData = [
			'code_id' => 1,
			'status_id' => 1,
			'category_id' => 1
			];

		$this->observationTypeUpdateData = [
			'code_id' => 2,
			'status_id' => 2,
			'category_id' => 2
			];
	}

	public function testListObservationType()
	{
		
		factory(\App\Models\ObservationType::class)->create($observationTypeData);
		$response = $this->json('GET', 'api/observationType/1', $ObservationTypeData);

		$this->assertDatabaseHas('panel_types', $ObservationTypeData);
		$response->assertStatus(200)->assertHasKey($ObservationTypeData);
	}

	public function testListObservationTypes()
	{
		$observationTypeData = array('code_id' => 1,
			'status_id' => 1,
			'category_id' => 1,
			);
		factory(\App\Models\ObservationType::class)->create($observationTypeData);
		$response = $this->json('GET', 'api/observationType', $observationTypeData);

		$this->assertDatabaseHas('panel_types', $observationTypeData);
		$response->assertStatus(200)->assertArrayHasKey($observationTypeData);
	}

	public function testStoreObservationType()
	{
		$faker = \Faker\Factory::create();
		$observationTypeData = array(
			'code_id' => $faker->randomNumber(),
			'status_id' => $faker->randomNumber(),
			'category_id' => $faker->randomNumber(),
		);
		$response = $this->json('POST', 'api/observationType', $observationTypeData);
		$this->assertDatabaseHas('panel_types', $observationTypeData);

		$response->assertStatus(200);
	}

	public function testUpdateObservationType()
	{
		$observationTypeData = ['code_id' => 1,
			'status_id' => 1,
			'category_id' => 1,];
		factory(\App\Models\ObservationType::class)->create($observationTypeData);

		$observationTypeDataUpdate = ['code_id' => 1,
			'status_id' => 1,
			'category_id' => 1,];

		$this->put('api/observationType/1', $observationTypeDataUpdate);

		$this->assertDatabaseHas('panel_types', $observationTypeDataUpdate);
	}

	public function testDeleteObservationType()
	{
		factory(\App\Models\ObservationType::class)->create();
		$response=$this->delete('api/observationType/1');
		$response->assertStatus(200);
	}
}