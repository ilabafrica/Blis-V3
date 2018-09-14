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

class ResultTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
	public function setVariables(){
		$this->resultData=array(
			"test_id"=>1,
			"measure_id"=>1,
			"result"=>'Sample String',
			"measure_range_id"=>1,
			"time_entered"=>'Sample String',
			"measures"=>1,
		);
		$this->updatedResultData=array(
			"test_id"=>1,
			"measure_id"=>1,
			"result"=>'Sample updated String',
			"measure_range_id"=>1,
			"time_entered"=>'Sample updated String',
			"measures"=>1,
		);
	}

	public function testStoreResult()
	{
		$response=$this->post('/api/result',$this->resultData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("time_entered",$response->original);
	}

	public function testListResult()
	{
		$response=$this->get('/api/result');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowResult()
	{
		$response=$this->post('/api/result',$this->resultData);
		$response=$this->get('/api/result/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("time_entered",$response->original);
	}

	public function testUpdateResult()
	{
		$response=$this->post('/api/result',$this->resultData);
		$response=$this->put('/api/result/1',$this->updatedResultData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("time_entered",$response->original);
	}

	public function testDeleteResult()
	{
		$response=$this->post('/api/result',$this->resultData);
		$response=$this->delete('/api/result/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}