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
            "practitioner_id"=>1,
			"name"=>'Sample String',
			"period"=>'2017:12:12 15:30:00',
			"issuer"=>1,
        );
    	$this->updatedpractitionerqualificationData=array(
            "practitioner_id"=>1,
			"name"=>'Sample updated String',
			"period"=>'2016:12:12 15:30:00',
			"issuer"=>1,
        );
	}

	public function testStorePractitionerQualification()
	{
		$response=$this->json('POST', '/api/practitionerqualification',$this->practitionerqualificationData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testListPractitionerQualification()
	{
		$response=$this->json('GET', '/api/practitionerqualification');
		$response->assertStatus(200);
		
	}

	public function testShowPractitionerQualification()
	{
		$this->json('POST', '/api/practitionerqualification',$this->practitionerqualificationData);
		$response=$this->json('GET', '/api/practitionerqualification/1');
		$response->assertStatus(200);
		$this->assertArrayHasKey("name",$response->original);
		
	}

	public function testUpdatePractitionerQualification()
	{
		$this->json('POST', '/api/practitionerqualification',$this->practitionerqualificationData);
		$response=$this->json('PUT', '/api/practitionerqualification/1',$this->updatedpractitionerqualificationData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("name",$response->original);
		
	}

	public function testDeletePractitionerQualification()
	{
		$this->json('POST', '/api/practitionerqualification',$this->practitionerqualificationData);
		$response=$this->delete('/api/practitionerqualification/1');
		$response->assertStatus(200);
		$response=$this->json('GET', '/api/practitionerqualification/1');
		$this->assertEquals(404, $response->getStatusCode());
		
	}

	public function testDeletePatientFail()
	{
		$response=$this->delete('/api/practitionerqualification/9999999999');
		$this->assertEquals(404, $response->getStatusCode());
	}

}