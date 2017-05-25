<?php

namespace Tests\Unit;

use App\Models\HumanName;
use App\Models\CodeableConcept;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

//A patient may have multiple names with different uses or applicable periods. For animals, the name is a "HumanName" in the sense that is assigned and used by humans and has the same patterns
class HumanNameTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}
	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	/**Test*/
	public function setVariables()
	{
		$this->HumannameData = array
		(
			'user_id' => factory(User::class)->create()->id,
			'use' => \Faker\Factory::create()->randomElement(['usual', 'official', 'temp', 'nickname', 'anonymous', 'old', 'maiden']),
			'text' => 'text_name',
			'family' => 'family_name',
			'given' => 'given_name',
			'prefix' => 'name_prefix',
			'suffix' => 'name_suffix',
			'period' => \Faker\Factory::create()->date()
			);
		$this->HumannameDataUpdate = array
		(

			 'use' => factory(CodeableConcept::class)->create()->id,
			'text' => 'text_name',
			'family' => 'family_name',
			'given' => 'given_name',
			'prefix' => 'name_prefix',
			'suffix' => 'name_suffix',
			'period' => \Faker\Factory::create()->date()
			);
	}
	public function testStoreHumannames()
	{
		$this->post('/api/humanname/', $this->HumannameData);

		$this->assertDatabaseHas('human_names',$this->HumannameData);
	}
	public function testUpdateHumanename()
	{
		//TODO
	}

	public function testHumannamesDelete()
	{
		//TODO
	}
	public function testShowHumanName()
	{
		//TODO
	}
}
