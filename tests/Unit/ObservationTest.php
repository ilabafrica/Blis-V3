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
			"created_by"=>1,
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
			"created_by"=>1,
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
		$response->assertStatus(200);
		$this->assertArrayHasKey("comment",$response->original);
	}

	public function testListObservation()
	{
		$response=$this->json('GET', '/api/observation');
		$response->assertStatus(200);
		
	}

	public function testShowObservation()
	{
		$this->json('POST', '/api/observation',$this->observationData);
		$response=$this->json('GET', '/api/observation/1');
		$response->assertStatus(200);
		$this->assertArrayHasKey("comment",$response->original);
	}

	public function testUpdateObservation()
	{
		$this->json('POST', '/api/observation',$this->observationData);
		$response=$this->json('PUT', '/api/observation/1',$this->updatedobservationData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("comment",$response->original);
	}

	public function testDeleteObservation()
	{
		$this->json('POST', '/api/observation',$this->observationData);
		$response=$this->delete('/api/observation/1');
		$response->assertStatus(200);
		$response=$this->json('GET', '/api/observation/1');
		$this->assertEquals(404, $response->getStatusCode());
		
	}

	public function testDeleteObservationFail()
	{
		$response=$this->delete('/api/observation/9999999999');
		$this->assertEquals(404, $response->getStatusCode());
	}

}