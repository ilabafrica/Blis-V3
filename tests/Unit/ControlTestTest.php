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

class ControlTestTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
	public function setVariables(){
		$this->controlTestData=array(
			"lot_id"=>1,
			"tested_by"=>1,
			"control_id"=>1,
			"control_type_id"=>1,
		);
		$this->updatedControlTestData=array(
			"lot_id"=>1,
			"tested_by"=>1,
			"control_id"=>1,
			"control_type_id"=>1,
		);
	}

	public function testStoreControlTest()
	{
		$response=$this->post('/api/controltest',$this->controlTestData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("control_type_id",$response->original);
	}

	public function testListControlTest()
	{
		$response=$this->get('/api/controltest');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowControlTest()
	{
		$response=$this->post('/api/controltest',$this->controlTestData);
		$response=$this->get('/api/controltest/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("control_type_id",$response->original);
	}

	public function testUpdateControlTest()
	{
		$response=$this->post('/api/controltest',$this->controlTestData);
		$response=$this->put('/api/controltest/1',$this->updatedControlTestData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("control_type_id",$response->original);
	}

	public function testDeleteControlTest()
	{
		$response=$this->post('/api/controltest',$this->controlTestData);
		$response=$this->delete('/api/controltest/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}