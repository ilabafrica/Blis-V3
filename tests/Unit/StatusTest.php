<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StatusTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
    	$this->statusData=array(
        
			"name"=>'Sample String',

        );
    	$this->updatedstatusData=array(
        
			"name"=>'Sample updated String',

        );
	}

	public function testStoreStatus()
	{
		$response=$this->json('POST', '/api/status',$this->statusData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testListStatus()
	{
		$response=$this->json('GET', '/api/status');
		$response->assertStatus(200);
		
	}

	public function testShowStatus()
	{
		$this->json('POST', '/api/status',$this->statusData);
		$response=$this->json('GET', '/api/status/1');
		$response->assertStatus(200);
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testUpdateStatus()
	{
		$this->json('POST', '/api/status',$this->statusData);
		$response=$this->json('PUT', '/api/status/1',$this->updatedstatusData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testDeleteStatus()
	{
		$this->json('POST', '/api/status',$this->statusData);
		$response=$this->delete('/api/status/1');
		$response->assertStatus(200);
		$response=$this->json('GET', '/api/status/1');
		$this->assertEquals(404, $response->getStatusCode());
		
	}

	public function testDeleteStatusFail()
	{
		$response=$this->delete('/api/status/9999999999');
		$this->assertEquals(404, $response->getStatusCode());
	}

}