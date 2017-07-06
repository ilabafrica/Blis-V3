<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ContainerTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
    	$this->containerData=array(
        
			"description"=>'Sample String',
			"type"=>1,
			"quantity_id"=>1,
			"additive"=>1,

        );
    	$this->updatedcontainerData=array(
        
			"description"=>'Sample updated String',
			"type"=>1,
			"quantity_id"=>1,
			"additive"=>1,

        );
	}

	public function testStoreContainer()
	{
		$response=$this->json('POST', '/api/container',$this->containerData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",$response->original);
	}

	public function testListContainer()
	{
		$response=$this->json('GET', '/api/container');
		$this->assertEquals(200,$response->getStatusCode());
		
	}

	public function testShowContainer()
	{
		$this->json('POST', '/api/container',$this->containerData);
		$response=$this->json('GET', '/api/container/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",$response->original);
	}

	public function testUpdateContainer()
	{
		$this->json('POST', '/api/container',$this->updatedcontainerData);
		$response=$this->json('PUT', '/api/container');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",$response->original);
	}

	public function testDeleteContainer()
	{
		$this->json('POST', '/api/container',$this->containerData);
		$response=$this->delete('/api/container/1');
		$this->assertEquals(200,$response->getStatusCode());
		
	}

}