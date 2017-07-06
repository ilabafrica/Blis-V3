<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PractitionerQualificationTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
    	$this->practitionerqualificationData=array(
        
			"name"=>'Sample String',
			"period"=>'2017:12:12 15:30:00',
        );
    	$this->updatedpractitionerqualificationData=array(
        
			"name"=>'Sample updated String',
			"period"=>'2016:12:12 15:30:00',
        );
	}

	public function testStorePractitionerQualification()
	{
		$response=$this->json('POST', '/api/practitionerqualification',$this->practitionerqualificationData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",$response->original);
	}

	public function testListPractitionerQualification()
	{
		$response=$this->json('GET', '/api/practitionerqualification');
		$this->assertEquals(200,$response->getStatusCode());
		
	}

	public function testShowPractitionerQualification()
	{
		$this->json('POST', '/api/practitionerqualification',$this->practitionerqualificationData);
		$response=$this->json('GET', '/api/practitionerqualification/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",$response->original);
	}

	public function testUpdatePractitionerQualification()
	{
		$this->json('POST', '/api/practitionerqualification',$this->updatedpractitionerqualificationData);
		$response=$this->json('PUT', '/api/practitionerqualification');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",$response->original);
	}

	public function testDeletePractitionerQualification()
	{
		$this->json('POST', '/api/practitionerqualification',$this->practitionerqualificationData);
		$response=$this->delete('/api/practitionerqualification/1');
		$this->assertEquals(200,$response->getStatusCode());
		
	}

}