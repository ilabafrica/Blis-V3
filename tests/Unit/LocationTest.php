<?php
namespace Tests\Unit;
/**
 * (c) @iLabAfrica
 * BLIS			 - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead	 - Emmanuel Kweyu.
 * Devs			 - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma|Anthony Ereng
 */

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LocationTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
		$this->locationData=array(
			"identifier"=>'Sample String',
			"name"=>'Sample String',
		);
		$this->updatedLocationData=array(
			"identifier"=>'Sample updated String',
			"name"=>'Sample updated String',
		);
	}

	public function testStoreLocation()
	{
		$response=$this->json('POST', '/api/location',$this->locationData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testListLocation()
	{
		$response=$this->json('GET', '/api/location');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowLocation()
	{
		$this->json('POST', '/api/location',$this->locationData);
		$response=$this->json('GET', '/api/location/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testUpdateLocation()
	{
		$this->json('POST', '/api/location',$this->locationData);
		$response=$this->json('PUT', '/api/location/1',$this->updatedLocationData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testDeleteLocation()
	{
		$this->json('POST', '/api/location',$this->locationData);
		$response=$this->delete('/api/location/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}