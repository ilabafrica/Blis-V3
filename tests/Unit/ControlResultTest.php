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

class ControlResultTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
	public function setVariables(){
		$this->controlResultData=array(
			"results"=>'Sample String',
			"control_measure_id"=>1,
			"control_test_id"=>1,
		);
		$this->updatedControlResultData=array(
			"results"=>'Sample updated String',
			"control_measure_id"=>1,
			"control_test_id"=>1,
		);
	}

	public function testStoreControlResult()
	{
		$response=$this->post('/api/controlresult',$this->controlResultData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("control_test_id",$response->original);
	}

	public function testListControlResult()
	{
		$response=$this->get('/api/controlresult');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowControlResult()
	{
		$response=$this->post('/api/controlresult',$this->controlResultData);
		$response=$this->get('/api/controlresult/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("control_test_id",$response->original);
	}

	public function testUpdateControlResult()
	{
		$response=$this->post('/api/controlresult',$this->controlResultData);
		$response=$this->put('/api/controlresult/1',$this->updatedControlResultData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("control_test_id",$response->original);
	}

	public function testDeleteControlResult()
	{
		$response=$this->post('/api/controlresult',$this->controlResultData);
		$response=$this->delete('/api/controlresult/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}