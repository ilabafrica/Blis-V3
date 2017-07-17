<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PractitionerTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
    	$this->practitionerData=array(
        
			"created_by"=>1,
			"gender"=>1,
			"birth_date"=>'2017:12:12 15:30:00',"photo"=>'Sample String',

        );
    	$this->updatedpractitionerData=array(
        
			"user_id"=>1,
			"gender"=>1,
			"birth_date"=>'2016:12:12 15:30:00',"photo"=>'Sample updated String',

        );
	}

	public function testStorePractitioner()
	{
		$response=$this->json('POST', '/api/practitioner',$this->practitionerData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",[$response->original]);
	}

	public function testListPractitioner()
	{
		$response=$this->json('GET', '/api/practitioner');
		$this->assertEquals(200,$response->getStatusCode());
		
	}

	public function testShowPractitioner()
	{
		$this->json('POST', '/api/practitioner',$this->practitionerData);
		$response=$this->json('GET', '/api/practitioner/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",[$response->original]);
	}

	public function testUpdatePractitioner()
	{
		$this->json('POST', '/api/practitioner',$this->updatedpractitionerData);
		$response=$this->json('PUT', '/api/practitioner');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",[$response->original]);
	}

	public function testDeletePractitioner()
	{
		$this->json('POST', '/api/practitioner',$this->practitionerData);
		$response=$this->delete('/api/practitioner/1');
		$this->assertEquals(200,$response->getStatusCode());
		
	}

}