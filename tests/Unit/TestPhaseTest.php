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

class TestPhaseTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
		$this->testPhaseData=array(
			"name"=>'Sample String',
		);
		$this->updatedTestPhaseData=array(
			"name"=>'Sample updated String',
		);
	}

	public function testStoreTestPhase()
	{
		$response=$this->json('POST', '/api/testphase',$this->testPhaseData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testListTestPhase()
	{
		$response=$this->json('GET', '/api/testphase');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowTestPhase()
	{
		$this->json('POST', '/api/testphase',$this->testPhaseData);
		$response=$this->json('GET', '/api/testphase/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testUpdateTestPhase()
	{
		$this->json('POST', '/api/testphase',$this->testPhaseData);
		$response=$this->json('PUT', '/api/testphase/1',$this->updatedTestPhaseData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testDeleteTestPhase()
	{
		$this->json('POST', '/api/testphase',$this->testPhaseData);
		$response=$this->delete('/api/testphase/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}