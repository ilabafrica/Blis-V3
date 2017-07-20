<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ObservationTypeTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
    	$this->observationtypeData=array(
        
			"status_id"=>1,
			"category_id"=>1,
			"code_id"=>1,
			"result_type"=>1,

        );
    	$this->updatedobservationtypeData=array(
        
			"status_id"=>1,
			"category_id"=>1,
			"code_id"=>1,
			"result_type"=>1,

        );
	}

	public function testStoreObservationType()
	{
		$response=$this->json('POST', '/api/observationtype',$this->observationtypeData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("code_id",$response->original);
	}

	public function testListObservationType()
	{
		$response=$this->json('GET', '/api/observationtype');
		$this->assertEquals(200);
		
	}

	public function testShowObservationType()
	{
		$this->json('POST', '/api/observationtype',$this->observationtypeData);
		$response=$this->json('GET', '/api/observationtype/1');
		$response->assertStatus(200);
		$this->assertArrayHasKey("code_id",$response->original);
	}

	public function testUpdateObservationType()
	{
		$this->json('POST', '/api/observationtype',$this->observationtypeData);
		$response=$this->json('PUT', '/api/observationtype/1',$this->updatedobservationtypeData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("code_id",$response->original);
	}

	public function testDeleteObservationType()
	{
		$this->json('POST', '/api/observationtype',$this->observationtypeData);
		$response=$this->delete('/api/observationtype/1');
		$response->assertStatus(200);
		
	}

}