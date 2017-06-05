<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PanelTest extends TestCase
{
	use DatabaseMigrations; //Run and drop migrations on all tests

	public function setup(){
		parent::setup();
		$this->setVariables();
	}
	
	public function setVariables()
	{
		$this->panelData = [
			'panel_type_id' => 1,
			'specimen_id' => 1,
			'conclusion' => "Civilized",
			'sort_order' => 1342
			];

		$this->panelUpdateData = [
			'panel_type_id' => 2,
			'specimen_id' => 2,
			'conclusion' => "UN-Civilized",
			'sort_order' => 4312
			];
	}

	public function testListPanel()
	{
		factory(\App\Models\Panel::class)->create($this->panelData);
		$response = $this->json('GET', 'api/panel/1');

		$this->assertDatabaseHas('panels', $this->panelData);
		$response->assertStatus(200)->assertHasKey($this->panelData);
	}

	public function testListPanel()
	{
		factory(\App\Models\Panel::class)->create($this->panelData);
		$response = $this->json('GET', 'api/panel');

		$this->assertDatabaseHas('panels', $this->panelData);
		$response->assertStatus(200)->assertArrayHasKey($this->panelData);
	}

	public function testStorePanel()
	{
		$faker = \Faker\Factory::create();
		$panelData = array(
			'panel_type_id' => factory(\App\Models\PanelType::class)->create()->id,
			'performed_by' => factory(\App\User::class)->create()->id,
			'specimen_id' => factory(\App\Models\Specimen::class)->create()->id,
			'conclusion' => $faker->word(),
			'coded_diagnosis_id' => factory(\App\Models\CodeableConcept::class)->create()->id,
			'status_id' => factory(\App\Models\CodeableConcept::class)->create()->id,
			'sort_order' => $faker->randomNumber(3)
		);
		$response = $this->json('POST', 'api/panel', $panelData);
		$this->assertDatabaseHas('panels', $panelData);

		$response->assertStatus(200);
	}

	public function testUpdatePanel()
	{
		factory(\App\Models\Panel::class)->create($this->panelData);
		$this->put('api/panel/1', $this->panelUpdateData);
		$this->assertDatabaseHas('panels', $this->panelUpdateData);
	}

	public function testDeletePanel()
	{
		factory(\App\Models\Panel::class)->create();
		$response=$this->delete('api/panel/1');
		$response->assertStatus(200);
	}

}