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

class CounterTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
		$this->counterData=array(
		);
		$this->updatedCounterData=array(
		);
	}

	public function testStoreCounter()
	{
		$response=$this->json('POST', '/api/counter',$this->counterData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("id",$response->original);
	}

	public function testListCounter()
	{
		$response=$this->json('GET', '/api/counter');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowCounter()
	{
		$this->json('POST', '/api/counter',$this->counterData);
		$response=$this->json('GET', '/api/counter/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("id",$response->original);
	}

	public function testUpdateCounter()
	{
		$this->json('POST', '/api/counter',$this->counterData);
		$response=$this->json('PUT', '/api/counter/1',$this->updatedCounterData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("id",$response->original);
	}

	public function testDeleteCounter()
	{
		$this->json('POST', '/api/counter',$this->counterData);
		$response=$this->delete('/api/counter/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}