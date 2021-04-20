<?php
namespace Tests\Unit;
/**
 * (c) @iLabAfrica
 * BLIS			 - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead	 - Emmanuel Kweyu.
 * Devs			 - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma|Anthony Ereng
 */

use Tests\SetUp;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SpecimenStatusTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
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
		$response=$this->post('/api/specimenstatus',$this->specimenStatusData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testListSpecimenStatus()
	{
		$response=$this->get('/api/specimenstatus');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowSpecimenStatus()
	{
		$response=$this->post('/api/specimenstatus',$this->specimenStatusData);
		$response=$this->get('/api/specimenstatus/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testUpdateSpecimenStatus()
	{
		$response=$this->post('/api/specimenstatus',$this->specimenStatusData);
		$response=$this->put('/api/specimenstatus/1',$this->updatedSpecimenStatusData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testDeleteSpecimenStatus()
	{
		$response=$this->post('/api/specimenstatus',$this->specimenStatusData);
		$response=$this->delete('/api/specimenstatus/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}