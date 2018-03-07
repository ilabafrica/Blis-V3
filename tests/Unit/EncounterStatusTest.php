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

class EncounterStatusTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
	public function setVariables(){
		$this->encounterStatusData=array(
			"name"=>'Sample String',
		);
		$this->updatedEncounterStatusData=array(
			"name"=>'Sample updated String',
		);
	}

	public function testStoreEncounterStatus()
	{
		$response=$this->post('/api/encounterstatus',$this->encounterStatusData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testListEncounterStatus()
	{
		$response=$this->get('/api/encounterstatus');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowEncounterStatus()
	{
		$response=$this->post('/api/encounterstatus',$this->encounterStatusData);
		$response=$this->get('/api/encounterstatus/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testUpdateEncounterStatus()
	{
		$response=$this->post('/api/encounterstatus',$this->encounterStatusData);
		$response=$this->put('/api/encounterstatus/1',$this->updatedEncounterStatusData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testDeleteEncounterStatus()
	{
		$response=$this->post('/api/encounterstatus',$this->encounterStatusData);
		$response=$this->delete('/api/encounterstatus/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}