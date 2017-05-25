<?php

namespace Tests\Unit;

use App\User;
use App\Models\ContactPoint;
use Faker\Generator as Facker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ContactPointTest extends TestCase
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

	public function setVariables()
	{
		$this->ContactPointData = array(
			'user_id' => factory(User::class)->create()->id,
			'system' =>  \Faker\Factory::create()->randomElement(['phone', 'fax', 'email', 'pager', 'url', 'sms', 'other']),
			'value' => \Faker\Factory::create()->word,
			'use' =>  \Faker\Factory::create()->randomElement(['home', 'work', 'temp', 'old', 'mobile']),
			'rank' => \Faker\Factory::create()->randomNumber(),
			'period' => \Faker\Factory::create()->date()
			);
		$this->ContactPointDataUpdate = array();
	}
	
	public function testStoreContactPoint()
	{
		$this->post('/api/contactpoint', $this->ContactPointData);

		$this->assertDatabaseHas('contact_points',$this->ContactPointData);
	}

	public function testUpdateContactPoint()
	{
		//TODO
	}

	 public function testContactPointDeleted()
	 {
		//TODO
	 }
	public function testShowContactPoint()
	{
		//TODO
	}
}
