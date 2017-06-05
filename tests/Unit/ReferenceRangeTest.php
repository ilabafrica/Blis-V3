<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ReferenceRangeTest extends TestCase
{
	use DatabaseMigrations; //Run and drop migrations on all tests

	public function setup(){
		parent::setup();
		$this->setVariables();
	}
	
	public function setVariables()
	{
		$this->referenceRangeData = array(
			'high_critical' => 1,
			'age_min' => 1,
			'age_max' => 1,
			);

		$this->referenceRangeUpdateData = [
			'high_critical' => 2,
			'age_min' => 2,
			'age_max' => 2,
			];
	}

	public function testListReferenceRange()
	{
		factory(\App\Models\ReferenceRange::class)->create($this->referenceRangeData);
		$response = $this->json('GET', 'api/referencerange/1');

		$this->assertDatabaseHas('reference_ranges', $this->referenceRangeData);
		$response->assertStatus(200)->assertHasKey($this->referenceRangeData);
	}

	public function testListReferenceranges()
	{
		factory(\App\Models\ReferenceRange::class)->create($this->referenceRangeData);
		$response = $this->json('GET', 'api/referencerange');

		$this->assertDatabaseHas('reference_ranges', $this->referenceRangeData);
		$response->assertStatus(200)->assertArrayHasKey($this->referenceRangeData);
	}

	public function testStoreReferencerange()
	{
		$faker = \Faker\Factory::create();
		$referenceRangeData = array(
			'high_critical' => $faker->randomNumber(),
			'age_min' => $faker->randomNumber(),
			'age_max' => $faker->randomNumber(),
		);
		$response = $this->json('POST', 'api/referencerange', $referenceRangeData);
		$this->assertDatabaseHas('reference_ranges', $referenceRangeData);

		$response->assertStatus(200);
	}

	public function testUpdateReferencerange()
	{
		factory(\App\Models\ReferenceRange::class)->create($this->referenceRangeData);

		$this->put('api/referencerange/1', $this->referenceRangeUpdateData);

		$this->assertDatabaseHas('reference_ranges', $this->referenceRangeUpdateData);
	}

	public function testDeleteReferencerange()
	{
		factory(\App\Models\ReferenceRange::class)->create();
		$response=$this->delete('api/referencerange/1');
		$response->assertStatus(200);
	}
}