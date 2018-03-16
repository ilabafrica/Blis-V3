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

class EncounterClassTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
	public function setVariables(){
		$this->encounterClassData=array(
			"name"=>'Sample String',
		);
		$this->updatedEncounterClassData=array(
			"name"=>'Sample updated String',
		);
	}

	public function testStoreEncounterClass()
	{
		$response=$this->post('/api/encounterclass',$this->encounterClassData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testListEncounterClass()
	{
		$response=$this->get('/api/encounterclass');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowEncounterClass()
	{
		$response=$this->post('/api/encounterclass',$this->encounterClassData);
		$response=$this->get('/api/encounterclass/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testUpdateEncounterClass()
	{
		$response=$this->post('/api/encounterclass',$this->encounterClassData);
		$response=$this->put('/api/encounterclass/1',$this->updatedEncounterClassData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testDeleteEncounterClass()
	{
		$response=$this->post('/api/encounterclass',$this->encounterClassData);
		$response=$this->delete('/api/encounterclass/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}