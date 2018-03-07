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

class CounterTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
	public function setVariables(){
		$this->counterData=array(
		);
		$this->updatedCounterData=array(
		);
	}

	public function testStoreCounter()
	{
		$response=$this->post('/api/counter',$this->counterData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("id",$response->original);
	}

	public function testListCounter()
	{
		$response=$this->get('/api/counter');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowCounter()
	{
		$response=$this->post('/api/counter',$this->counterData);
		$response=$this->get('/api/counter/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("id",$response->original);
	}

	public function testUpdateCounter()
	{
		$response=$this->post('/api/counter',$this->counterData);
		$response=$this->put('/api/counter/1',$this->updatedCounterData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("id",$response->original);
	}

	public function testDeleteCounter()
	{
		$response=$this->post('/api/counter',$this->counterData);
		$response=$this->delete('/api/counter/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}