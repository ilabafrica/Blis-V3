<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SpecimenTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
    	$this->specimenData=array(
        
			"status"=>1,
			"type"=>1,
			"note"=>'Sample String',

        );
    	$this->updatedspecimenData=array(
        
			"status"=>1,
			"type"=>1,
			"note"=>'Sample updated String',

        );
	}

	public function testStoreSpecimen()
	{
		$response=$this->json('POST', '/api/specimen',$this->specimenData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",$response->original);
	}

	public function testListSpecimen()
	{
		$response=$this->json('GET', '/api/specimen');
		$this->assertEquals(200,$response->getStatusCode());
		
	}

	public function testShowSpecimen()
	{
		$this->json('POST', '/api/specimen',$this->specimenData);
		$response=$this->json('GET', '/api/specimen/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",$response->original);
	}

	public function testUpdateSpecimen()
	{
		$this->json('POST', '/api/specimen',$this->updatedspecimenData);
		$response=$this->json('PUT', '/api/specimen');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",$response->original);
	}

	public function testDeleteSpecimen()
	{
		$this->json('POST', '/api/specimen',$this->specimenData);
		$response=$this->delete('/api/specimen/1');
		$this->assertEquals(200,$response->getStatusCode());
		
	}

}