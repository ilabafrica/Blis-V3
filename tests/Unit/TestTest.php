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

class TestTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
	public function setVariables(){
		$this->testData=array(
			"encounter_id"=>1,
			"identifier"=>'Sample String',
			"test_type_id"=>1,
			"specimen_id"=>1,
			"test_status_id"=>1,
			"created_by"=>1,
			"tested_by"=>1,
			"verified_by"=>1,
			"requested_by"=>'Sample String',
			"time_started"=>'Sample String',
			"time_completed"=>'Sample String',
			"time_verified"=>'Sample String',
			"time_sent"=>'Sample String',
		);
		$this->updatedTestData=array(
			"encounter_id"=>1,
			"identifier"=>'Sample updated String',
			"test_type_id"=>1,
			"specimen_id"=>1,
			"test_status_id"=>1,
			"created_by"=>1,
			"tested_by"=>1,
			"verified_by"=>1,
			"requested_by"=>'Sample updated String',
			"time_started"=>'Sample updated String',
			"time_completed"=>'Sample updated String',
			"time_verified"=>'Sample updated String',
			"time_sent"=>'Sample updated String',
		);
	}

	public function testStoreTest()
	{
		$response=$this->post('/api/test',$this->testData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("time_sent",$response->original);
	}

	public function testListTest()
	{
		$response=$this->get('/api/test');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowTest()
	{
		$response=$this->post('/api/test',$this->testData);
		$response=$this->get('/api/test/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("time_sent",$response->original);
	}

	public function testUpdateTest()
	{
		$response=$this->post('/api/test',$this->testData);
		$response=$this->put('/api/test/1',$this->updatedTestData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("time_sent",$response->original);
	}

	public function testDeleteTest()
	{
		$response=$this->post('/api/test',$this->testData);
		$response=$this->delete('/api/test/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}