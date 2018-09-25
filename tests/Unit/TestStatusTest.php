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

class TestStatusTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
	public function setVariables(){
		$this->testStatusData=array(
			"name"=>'Sample String',
			"test_phase_id"=>1,
			"code"=> 'Sample String',
		);
		$this->updatedTestStatusData=array(
			"name"=>'Sample updated String',
			"test_phase_id"=>1,
			"code"=> 'Sample String',
		);
	}

	public function testStoreTestStatus()
	{
		$response=$this->post('/api/testStatus',$this->testStatusData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("test_phase_id",$response->original);
	}

	public function testListTestStatus()
	{
		$response=$this->get('/api/testStatus');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowTestStatus()
	{
		$response=$this->post('/api/testStatus',$this->testStatusData);
		$response=$this->get('/api/testStatus/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("test_phase_id",$response->original);
	}

	public function testUpdateTestStatus()
	{
		$response=$this->post('/api/testStatus',$this->testStatusData);
		$response=$this->put('/api/testStatus/1',$this->updatedTestStatusData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("test_phase_id",$response->original);
	}

	public function testDeleteTestStatus()
	{
		$response=$this->post('/api/testStatus',$this->testStatusData);
		$response=$this->delete('/api/testStatus/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}