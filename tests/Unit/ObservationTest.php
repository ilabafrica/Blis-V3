<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ObservationTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
    	$this->observationData=array(
        
			"status_id"=>1,
			"category_id"=>1,
			"panel_id"=>1,
			"user_id"=>1,
			"quantity_id"=>1,
			"data_absent_reason"=>1,
			"interpretation"=>1,
			"comment"=>'Sample String',
			"issued"=>'2017:12:12 15:30:00',
        );
    	$this->updatedobservationData=array(
        
			"status_id"=>1,
			"category_id"=>1,
			"panel_id"=>1,
			"user_id"=>1,
			"quantity_id"=>1,
			"data_absent_reason"=>1,
			"interpretation"=>1,
			"comment"=>'Sample updated String',
			"issued"=>'2016:12:12 15:30:00',
        );
	}

	public function testStoreObservation()
	{
		$response=$this->json('POST', '/api/observation',$this->observationData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",$response->original);
	}

	public function testListObservation()
	{
		$response=$this->json('GET', '/api/observation');
		$this->assertEquals(200,$response->getStatusCode());
		
	}

	public function testShowObservation()
	{
		$this->json('POST', '/api/observation',$this->observationData);
		$response=$this->json('GET', '/api/observation/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",$response->original);
	}

	public function testUpdateObservation()
	{
		$this->json('POST', '/api/observation',$this->updatedobservationData);
		$response=$this->json('PUT', '/api/observation');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",$response->original);
	}

	public function testDeleteObservation()
	{
		$this->json('POST', '/api/observation',$this->observationData);
		$response=$this->delete('/api/observation/1');
		$this->assertEquals(200,$response->getStatusCode());
		
	}

}