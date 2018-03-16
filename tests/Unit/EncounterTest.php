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

class EncounterTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
	public function setVariables(){
		$this->encounterData=array(
			"identifier"=>'Sample String',
			"patient_id"=>1,
			"location_id"=>'Sample String',
			"encounter_class_id"=>1,
			"encounter_status_id"=>1,
			"bed_no"=>'Sample String',
		);
		$this->updatedEncounterData=array(
			"identifier"=>'Sample updated String',
			"patient_id"=>1,
			"location_id"=>'Sample updated String',
			"encounter_class_id"=>1,
			"encounter_status_id"=>1,
			"bed_no"=>'Sample updated String',
		);
	}

	public function testStoreEncounter()
	{
		$response=$this->post('/api/encounter',$this->encounterData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("bed_no",$response->original);
	}

	public function testListEncounter()
	{
		$response=$this->get('/api/encounter');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowEncounter()
	{
		$response=$this->post('/api/encounter',$this->encounterData);
		$response=$this->get('/api/encounter/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("bed_no",$response->original);
	}

	public function testUpdateEncounter()
	{
		$response=$this->post('/api/encounter',$this->encounterData);
		$response=$this->put('/api/encounter/1',$this->updatedEncounterData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("bed_no",$response->original);
	}

	public function testDeleteEncounter()
	{
		$response=$this->post('/api/encounter',$this->encounterData);
		$response=$this->delete('/api/encounter/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}