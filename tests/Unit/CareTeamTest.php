<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CareTeamTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
    	$this->careteamData=array(
        
			"identifiers"=>'Sample String',
			"status_id"=>1,
			"category"=>1,
			"name"=>'Sample String',
			"subject"=>1,
			"context"=>1,
			"reason_code"=>1,
			"reason_reference"=>'Sample String',
			"organization_id"=>1,
			"comment"=>'Sample String',

        );
    	$this->updatedcareteamData=array(
        
			"identifiers"=>'Sample updated String',
			"status_id"=>1,
			"category"=>1,
			"name"=>'Sample updated String',
			"subject"=>1,
			"context"=>1,
			"reason_code"=>1,
			"reason_reference"=>'Sample updated String',
			"organization_id"=>1,
			"comment"=>'Sample updated String',

        );
	}

	public function testStoreCareTeam()
	{
		$response=$this->json('POST', '/api/careteam',$this->careteamData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",[$response->original]);
	}

	public function testListCareTeam()
	{
		$response=$this->json('GET', '/api/careteam');
		$this->assertEquals(200,$response->getStatusCode());
		
	}

	public function testShowCareTeam()
	{
		$this->json('POST', '/api/careteam',$this->careteamData);
		$response=$this->json('GET', '/api/careteam/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",$response->original);
	}

	public function testUpdateCareTeam()
	{
		$this->json('POST', '/api/careteam',$this->updatedcareteamData);
		$response=$this->json('PUT', '/api/careteam');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",$response->original);
	}

	public function testDeleteCareTeam()
	{
		$this->json('POST', '/api/careteam',$this->careteamData);
		$response=$this->delete('/api/careteam/1');
		$this->assertEquals(200,$response->getStatusCode());
		
	}

}