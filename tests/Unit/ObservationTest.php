<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ObservationTest extends TestCase
{
	use DatabaseMigrations; //Run and drop migrations on all tests

	public function setup(){
		parent::setup();
		$this->setVariables();
	}
	
	public function setVariables()
	{
		$this->observationData = array(
			'panel_id' => 1,
			'status_id' => 1,
			'category_id' => 1
			);

		$this->observationDataUpdate = [
			'panel_id' => 2,
			'status_id' => 2,
			'category_id' => 2
			];
	}

	public function testListObservation()
	{
		factory(\App\Models\Observation::class)->create($this->observationData);
		$response = $this->json('GET', 'api/observation/1');

		$this->assertDatabaseHas('observations', $this->observationData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("category_id", $response->original);
	}

	public function testListObservations()
	{
		$observationData = array('panel_id' => 1,
			'status_id' => 1,
			'category_id' => 1,
			);
		factory(\App\Models\Observation::class)->create($this->observationData);
		$response = $this->json('GET', 'api/observation');

		$this->assertDatabaseHas('observations', $this->observationData);
		$response->assertStatus(200);
	}

	public function testStoreObservation()
	{
		$faker = \Faker\Factory::create();
		$observationData = array(
			'panel_id' => $faker->randomNumber(),
			'status_id' => $faker->randomNumber(),
			'category_id' => $faker->randomNumber(),
		);
		$response = $this->json('POST', 'api/observation', $observationData);
		$this->assertDatabaseHas('observations', $observationData);

		$response->assertStatus(200);
		$this->assertArrayHasKey("category_id", $response->original);
	}

	public function testUpdateObservation()
	{
		$observationData = ['panel_id' => 1,
			'status_id' => 1,
			'category_id' => 1,];
		factory(\App\Models\Observation::class)->create($observationData);

		$response = $this->json('PUT', 'api/observation/1', $this->observationDataUpdate);
		$this->assertDatabaseHas('observations', $this->observationDataUpdate);
		$this->assertArrayHasKey("category_id", $response->original);
	}

	public function testDeleteObservation()
	{
		factory(\App\Models\PanelType::class)->create();
		$response=$this->json('DELETE', 'api/observation/1');
		$response->assertStatus(200);
		$this->assertArrayHasKey("category_id", $response->original);
	}
}