<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PanelTest extends TestCase
{
	use DatabaseMigrations;

	public function testSavePanel()
	{
		$faker = \Faker\Factory::create();
		$panelTypeData = array(
			'code_id' => $faker->randomNumber(),
			'status_id' => $faker->randomNumber(),
			'category_id' => $faker->randomNumber(),
		);
		$response = $this->json('POST', 'api/panel', $panelTypeData);
		$this->assertDatabaseHas('panels', $panelTypeData);

		$response->assertStatus(200)->assertExactJson(['created' => true,]);
	}

}