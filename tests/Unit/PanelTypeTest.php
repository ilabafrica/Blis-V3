<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PanelTypeTest extends TestCase
{
	use DatabaseMigrations;

	public function testListPanelType()
	{
		$panelTypeData = ['code_id' => 1,
			'status_id' => 1,
			'category_id' => 1,];
		factory(\App\Models\PanelType::class)->create($panelTypeData);
		$response = $this->json('GET', '/paneltype', $panelTypeData);

		$this->assertDatabaseHas('panel_types', $panelTypeData);
		$response->assertStatus(200)->assertJsonFragment($panelTypeData);
	}

	public function testStorePanelType()
	{
		$faker = \Faker\Factory::create();
		$panelTypeData = array(
			'code_id' => $faker->randomNumber(),
			'status_id' => $faker->randomNumber(),
			'category_id' => $faker->randomNumber(),
		);
		$response = $this->json('POST', '/paneltype', $panelTypeData);
		$this->assertDatabaseHas('panel_types', $panelTypeData);

		$response->assertStatus(200)->assertExactJson(['created' => true,]);
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

		$this->put('/paneltype/1', $panelTypeDataUpdate);

		$this->assertDatabaseHas('panel_types', $panelTypeDataUpdate);
	}

	public function testDeletePanelType()
	{
		factory(\App\Models\PanelType::class)->create();
		$response=$this->delete('/api/paneltype/1');
		$response->assertStatus(200)->assertExactJson(['deleted' => true,]);
	}
}