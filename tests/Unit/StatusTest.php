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
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",[$response->original]);
	}

	public function testListStatus()
	{
		$response=$this->json('GET', '/api/status');
		$this->assertEquals(200,$response->getStatusCode());
		
	}

	public function testShowStatus()
	{
		$this->json('POST', '/api/status',$this->statusData);
		$response=$this->json('GET', '/api/status/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",[$response->original]);
	}

	public function testUpdateStatus()
	{
		$this->json('POST', '/api/status',$this->updatedstatusData);
		$response=$this->json('PUT', '/api/status');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",[$response->original]);
	}

	public function testDeleteStatus()
	{
		$this->json('POST', '/api/status',$this->statusData);
		$response=$this->delete('/api/status/1');
		$this->assertEquals(200,$response->getStatusCode());
		
	}

}