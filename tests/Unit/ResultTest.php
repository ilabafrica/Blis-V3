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

class ResultTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
		$this->resultData=array(
			"test_id"=>1,
			"measure_id"=>1,
			"result"=>'Sample String',
			"measure_range_id"=>1,
			"time_entered"=>'Sample String',
		);
		$this->updatedResultData=array(
			"test_id"=>1,
			"measure_id"=>1,
			"result"=>'Sample updated String',
			"measure_range_id"=>1,
			"time_entered"=>'Sample updated String',
		);
	}

	public function testStoreResult()
	{
		$response=$this->json('POST', '/api/result',$this->resultData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("time_entered",$response->original);
	}

	public function testListResult()
	{
		$response=$this->json('GET', '/api/result');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowResult()
	{
		$this->json('POST', '/api/result',$this->resultData);
		$response=$this->json('GET', '/api/result/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("time_entered",$response->original);
	}

	public function testUpdateResult()
	{
		$this->json('POST', '/api/result',$this->resultData);
		$response=$this->json('PUT', '/api/result/1',$this->updatedResultData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("time_entered",$response->original);
	}

	public function testDeleteResult()
	{
		$this->json('POST', '/api/result',$this->resultData);
		$response=$this->delete('/api/result/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}