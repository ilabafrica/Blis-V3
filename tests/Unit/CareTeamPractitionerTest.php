<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CareTeamPractitionerTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
    	$this->careteampractitionerData=array(
        
			"team_id"=>1,
			"practioner_id"=>1,

        );
    	$this->updatedcareteampractitionerData=array(
        
			"team_id"=>1,
			"practioner_id"=>1,

        );
	}

	public function testStoreCareTeamPractitioner()
	{
		$response=$this->json('POST', '/api/careteampractitioner',$this->careteampractitionerData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",$response->original);
	}

	public function testListCareTeamPractitioner()
	{
		$response=$this->json('GET', '/api/careteampractitioner');
		$this->assertEquals(200,$response->getStatusCode());
		
	}

	public function testShowCareTeamPractitioner()
	{
		$this->json('POST', '/api/careteampractitioner',$this->careteampractitionerData);
		$response=$this->json('GET', '/api/careteampractitioner/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",$response->original);
	}

	public function testUpdateCareTeamPractitioner()
	{
		$this->json('POST', '/api/careteampractitioner',$this->updatedcareteampractitionerData);
		$response=$this->json('PUT', '/api/careteampractitioner');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",$response->original);
	}

	public function testDeleteCareTeamPractitioner()
	{
		$this->json('POST', '/api/careteampractitioner',$this->careteampractitionerData);
		$response=$this->delete('/api/careteampractitioner/1');
		$this->assertEquals(200,$response->getStatusCode());
		
	}

}