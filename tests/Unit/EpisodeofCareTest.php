<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EpisodeofCareTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
    	$this->episodeofcareData=array(
        
			"status"=>1,
			"type"=>1,
			"patient"=>1,
			"organization_id"=>1,
			"practitioners_id"=>1,
			"team_id"=>1,

        );
    	$this->updatedepisodeofcareData=array(
        
			"status"=>1,
			"type"=>1,
			"patient"=>1,
			"organization_id"=>1,
			"practitioners_id"=>1,
			"team_id"=>1,

        );
	}

	public function testStoreEpisodeofCare()
	{
		$response=$this->json('POST', '/api/episodeofcare',$this->episodeofcareData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("patient",$response->original);
	}

	public function testListEpisodeofCare()
	{
		$response=$this->json('GET', '/api/episodeofcare');
		$response->assertStatus(200);
		
	}

	public function testShowEpisodeofCare()
	{
		$this->json('POST', '/api/episodeofcare',$this->episodeofcareData);
		$response=$this->json('GET', '/api/episodeofcare/1');
		$response->assertStatus(200);
		$this->assertArrayHasKey("patient",$response->original);
	}

	public function testUpdateEpisodeofCare()
	{
		$this->json('POST', '/api/episodeofcare',$this->episodeofcareData);
		$response=$this->json('PUT', '/api/episodeofcare/1',$this->updatedepisodeofcareData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("patient",$response->original);
	}

	public function testDeleteEpisodeofCare()
	{
		$this->json('POST', '/api/episodeofcare',$this->episodeofcareData);
		$response=$this->delete('/api/episodeofcare/1');
		$response->assertStatus(200);
		
	}

}