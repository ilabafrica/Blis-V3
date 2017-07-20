<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StatusHistoryTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
    	$this->statushistoryData=array(
        
			"code"=>1,
			"episode_of_care_id"=>1,

        );
    	$this->updatedstatushistoryData=array(
        
			"code"=>1,
			"episode_of_care_id"=>1,

        );
	}

	public function testStoreStatusHistory()
	{
		$response=$this->json('POST', '/api/statushistory',$this->statushistoryData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("episode_of_care_id",$response->original);
	}

	public function testListStatusHistory()
	{
		$response=$this->json('GET', '/api/statushistory');
		$response->assertStatus(200);
		
	}

	public function testShowStatusHistory()
	{
		$this->json('POST', '/api/statushistory',$this->statushistoryData);
		$response=$this->json('GET', '/api/statushistory/1');
		$response->assertStatus(200);
		$this->assertArrayHasKey("episode_of_care_id",$response->original);
	}

	public function testUpdateStatusHistory()
	{
		$this->json('POST', '/api/statushistory',$this->statushistoryData);
		$response=$this->json('PUT', '/api/statushistory/1',$this->updatedstatushistoryData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("episode_of_care_id",$response->original);
	}

	public function testDeleteStatusHistory()
	{
		$this->json('POST', '/api/statushistory',$this->statushistoryData);
		$response=$this->delete('/api/statushistory/1');
		$response->assertStatus(200);
		
	}

}