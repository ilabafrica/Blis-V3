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
		$this->observationTypeData = [
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
		
		factory(\App\Models\ObservationType::class)->create($this->observationTypeData);
		$response = $this->json('GET', 'api/observationtype/1');

		$this->assertDatabaseHas('observation_types', $this->observationTypeData);
		$response->assertStatus(200)->assertHasKey($this->observationTypeData);
	}

	public function testListObservationTypes()
	{
		$observationTypeData = array('code_id' => 1,
			'status_id' => 1,
			'category_id' => 1,
			);
		factory(\App\Models\ObservationType::class)->create($this->observationTypeData);
		$response = $this->json('GET', 'api/observationtype');

		$this->assertDatabaseHas('observation_types', $this->observationTypeData);
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
		$response = $this->json('POST', 'api/observationtype', $observationTypeData);
		$this->assertDatabaseHas('observation_types', $observationTypeData);
		$response->assertStatus(200);
	}

	public function testUpdateObservationType()
	{
		$observationTypeData = ['code_id' => 1,
			'status_id' => 1,
			'category_id' => 1,];
		factory(\App\Models\ObservationType::class)->create($observationTypeData);
		$this->put('api/observationtype/1', $this->observationTypeUpdateData);
		$this->assertDatabaseHas('observation_types', $this->observationTypeUpdateData);
	}

	public function testDeleteObservationType()
	{
		factory(\App\Models\ObservationType::class)->create();
		$response=$this->delete('api/observationtype/1');
		$response->assertStatus(200);
	}
}