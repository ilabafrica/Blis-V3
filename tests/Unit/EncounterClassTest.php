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

class EncounterClassTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

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
		$response=$this->json('POST', '/api/encounterclass',$this->encounterClassData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testListEncounterClass()
	{
		$response=$this->json('GET', '/api/encounterclass');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowEncounterClass()
	{
		$this->json('POST', '/api/encounterclass',$this->encounterClassData);
		$response=$this->json('GET', '/api/encounterclass/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testUpdateEncounterClass()
	{
		$this->json('POST', '/api/encounterclass',$this->encounterClassData);
		$response=$this->json('PUT', '/api/encounterclass/1',$this->updatedEncounterClassData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testDeleteEncounterClass()
	{
		$this->json('POST', '/api/encounterclass',$this->encounterClassData);
		$response=$this->delete('/api/encounterclass/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}