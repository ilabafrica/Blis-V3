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

class TestMappingTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
	public function setVariables(){
		$this->testMappingData=array(
			"code_id"=>1,
			"test_type_id"=>1,
			"specimen_type_id"=>1,
		);
		$this->updatedTestMappingData=array(
			"code_id"=>1,
			"test_type_id"=>1,
			"specimen_type_id"=>1,
		);
	}

	public function testStoreTestMapping()
	{
		$response=$this->post('/api/testtypemapping',$this->testMappingData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("specimen_type_id",$response->original);
	}

	public function testListTestMapping()
	{
		$response=$this->get('/api/testtypemapping');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowTestMapping()
	{
		$response=$this->post('/api/testtypemapping',$this->testMappingData);
		$response=$this->get('/api/testtypemapping/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("specimen_type_id",$response->original);
	}

	public function testUpdateTestMapping()
	{
		$response=$this->post('/api/testtypemapping',$this->testMappingData);
		$response=$this->put('/api/testtypemapping/1',$this->updatedTestMappingData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("specimen_type_id",$response->original);
	}

	public function testDeleteTestMapping()
	{
		$response=$this->post('/api/testtypemapping',$this->testMappingData);
		$response=$this->delete('/api/testtypemapping/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}