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

class TestPhaseTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
	public function setVariables(){
		$this->testPhaseData=array(
			"code"=>'Sample String',
			"display"=>'Sample String',
		);
		$this->updatedTestPhaseData=array(
			"code"=>1,
			"display"=>'Sample updated String',
		);
	}

	public function testStoreTestPhase()
	{
		$response=$this->post('/api/testphase',$this->testPhaseData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("display",$response->original);
	}

	public function testListTestPhase()
	{
		$response=$this->get('/api/testphase');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowTestPhase()
	{
		$response=$this->post('/api/testphase',$this->testPhaseData);
		$response=$this->get('/api/testphase/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("display",$response->original);
	}

	public function testUpdateTestPhase()
	{
		$response=$this->post('/api/testphase',$this->testPhaseData);
		$response=$this->put('/api/testphase/1',$this->updatedTestPhaseData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("display",$response->original);
	}

	public function testDeleteTestPhase()
	{
		$response=$this->post('/api/testphase',$this->testPhaseData);
		$response=$this->delete('/api/testphase/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}