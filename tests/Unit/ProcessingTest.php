<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProcessingTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
    	$this->processingData=array(
        
			"description"=>'Sample String',
			"procedure"=>1,

        );
    	$this->updatedprocessingData=array(
        
			"description"=>'Sample updated String',
			"procedure"=>1,

        );
	}

	public function testStoreProcessing()
	{
		$response=$this->json('POST', '/api/processing',$this->processingData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("description",$response->original);
	}

	public function testListProcessing()
	{
		$response=$this->json('GET', '/api/processing');
		$response->assertStatus(200);
		
	}

	public function testShowProcessing()
	{
		$this->json('POST', '/api/processing',$this->processingData);
		$response=$this->json('GET', '/api/processing/1');
		$response->assertStatus(200);
		$this->assertArrayHasKey("description",$response->original);
	}

	public function testUpdateProcessing()
	{
		$this->json('POST', '/api/processing',$this->processingData);
		$response=$this->json('PUT', '/api/processing/1',$this->updatedprocessingData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("description",$response->original);
	}

	public function testDeleteProcessing()
	{
		$this->json('POST', '/api/processing',$this->processingData);
		$response=$this->delete('/api/processing/1');
		$response->assertStatus(200);
		
	}

}