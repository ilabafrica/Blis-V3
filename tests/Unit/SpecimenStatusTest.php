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

class SpecimenStatusTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
		$this->specimenStatusData=array(
			"name"=>'Sample String',
		);
		$this->updatedSpecimenStatusData=array(
			"name"=>'Sample updated String',
		);
	}

	public function testStoreSpecimenStatus()
	{
		$response=$this->json('POST', '/api/specimenstatus',$this->specimenStatusData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testListSpecimenStatus()
	{
		$response=$this->json('GET', '/api/specimenstatus');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowSpecimenStatus()
	{
		$this->json('POST', '/api/specimenstatus',$this->specimenStatusData);
		$response=$this->json('GET', '/api/specimenstatus/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testUpdateSpecimenStatus()
	{
		$this->json('POST', '/api/specimenstatus',$this->specimenStatusData);
		$response=$this->json('PUT', '/api/specimenstatus/1',$this->updatedSpecimenStatusData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testDeleteSpecimenStatus()
	{
		$this->json('POST', '/api/specimenstatus',$this->specimenStatusData);
		$response=$this->delete('/api/specimenstatus/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}