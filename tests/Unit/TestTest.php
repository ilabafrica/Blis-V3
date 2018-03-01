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

class TestTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

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
		$response=$this->json('POST', '/api/test',$this->testData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("time_sent",$response->original);
	}

	public function testListTest()
	{
		$response=$this->json('GET', '/api/test');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowTest()
	{
		$this->json('POST', '/api/test',$this->testData);
		$response=$this->json('GET', '/api/test/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("time_sent",$response->original);
	}

	public function testUpdateTest()
	{
		$this->json('POST', '/api/test',$this->testData);
		$response=$this->json('PUT', '/api/test/1',$this->updatedTestData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("time_sent",$response->original);
	}

	public function testDeleteTest()
	{
		$this->json('POST', '/api/test',$this->testData);
		$response=$this->delete('/api/test/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}