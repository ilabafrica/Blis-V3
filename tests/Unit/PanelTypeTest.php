<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PanelTypeTest extends TestCase
{
	use DatabaseMigrations; //Run and drop migrations on all tests

	public function setup(){
		parent::setup();
		$this->setVariables();
	}
	
	public function setVariables()
	{
		$panelTypeData = [
			'code_id' => 1,
			'status_id' => 1,
			'category_id' => 1
			];

		$this->panelUpdateData = [
			'code_id' => 2,
			'status_id' => 2,
			'category_id' => 2
			];
	}

	public function testListPanelType()
	{
		
		factory(\App\Models\PanelType::class)->create($panelTypeData);
		$response = $this->json('GET', 'api/paneltype/1', $panelTypeData);

		$this->assertDatabaseHas('panel_types', $panelTypeData);
		$response->assertStatus(200)->assertHasKey($panelTypeData);
	}

	public function testListPanelTypes()
	{
		$panelTypeData = array('code_id' => 1,
			'status_id' => 1,
			'category_id' => 1,
			);
		factory(\App\Models\PanelType::class)->create($panelTypeData);
		$response = $this->json('GET', 'api/paneltype', $panelTypeData);

		$this->assertDatabaseHas('panel_types', $panelTypeData);
		$response->assertStatus(200)->assertArrayHasKey($panelTypeData);
	}

	public function testStorePanelType()
	{
		$faker = \Faker\Factory::create();
		$panelTypeData = array(
			'code_id' => $faker->randomNumber(),
			'status_id' => $faker->randomNumber(),
			'category_id' => $faker->randomNumber(),
		);
		$response = $this->json('POST', 'api/paneltype', $panelTypeData);
		$this->assertDatabaseHas('panel_types', $panelTypeData);

		$response->assertStatus(200);
	}

	public function testUpdatePanelType()
	{
		$panelTypeData = ['code_id' => 1,
			'status_id' => 1,
			'category_id' => 1,];
		factory(\App\Models\PanelType::class)->create($panelTypeData);

		$panelTypeDataUpdate = ['code_id' => 1,
			'status_id' => 1,
			'category_id' => 1,];

		$this->put('api/paneltype/1', $panelTypeDataUpdate);

		$this->assertDatabaseHas('panel_types', $panelTypeDataUpdate);
	}

	public function testDeletePanelType()
	{
		factory(\App\Models\PanelType::class)->create();
		$response=$this->delete('api/paneltype/1');
		$response->assertStatus(200);
	}
}