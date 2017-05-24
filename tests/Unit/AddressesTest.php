<?php

namespace Tests\Unit;

use App\Models\Address;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

 //Address for the contact person.
class AddressesTest extends TestCase
{
	use DatabaseMigrations;

	public function setup()
	{
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
		$this->AddressData = array
		(
		 'use' =>  \Faker\Factory::create()->randomElement(['home', 'work', 'temp', 'old']),
			'type' =>  \Faker\Factory::create()->randomElement(['postal', 'physical', 'both']),
			'text' => \Faker\Factory::create()->word,
			'line' => \Faker\Factory::create()->word,
			'city' => \Faker\Factory::create()->word,
			'district' => \Faker\Factory::create()->word,
			'state' => \Faker\Factory::create()->word,
			'postal_code' => \Faker\Factory::create()->word,
			'country' => \Faker\Factory::create()->word,
			'period' => \Faker\Factory::create()->date(),
			);
		$this->AddressDataUpdate = array (
			
			 'text' => \Faker\Factory::create()->word,
			'line' => \Faker\Factory::create()->word,
			'city' => \Faker\Factory::create()->word,
			'district' => \Faker\Factory::create()->word,
			'state' => \Faker\Factory::create()->word,
			'postal_code' => \Faker\Factory::create()->word,
			'country' => \Faker\Factory::create()->word,
			);
	}
	public function testStoreAddresses()
	{
		$Addresses = $this->AddressData;

		$this->post('/api/address', $Addresses);

		$this->assertDatabaseHas('addresses',$this->AddressData);
	}
	public function testUpdateAddresses()
	{
		//TODO
	}

	public function testDeleteAddress()
	{
		//TODO
	}
	public function testShowAddress()
	{
		//TODO
	}
}
