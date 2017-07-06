<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PatientContactTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
    	$this->patientcontactData=array(
        
			"relationship"=>1,
			"gender"=>1,
			"period"=>'2017:12:12 15:30:00',
        );
    	$this->updatedpatientcontactData=array(
        
			"relationship"=>1,
			"gender"=>1,
			"period"=>'2016:12:12 15:30:00',
        );
	}

	public function testStorePatientContact()
	{
		$response=$this->json('POST', '/api/patientcontact',$this->patientcontactData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",$response->original);
	}

	public function testListPatientContact()
	{
		$response=$this->json('GET', '/api/patientcontact');
		$this->assertEquals(200,$response->getStatusCode());
		
	}

	public function testShowPatientContact()
	{
		$this->json('POST', '/api/patientcontact',$this->patientcontactData);
		$response=$this->json('GET', '/api/patientcontact/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",$response->original);
	}

	public function testUpdatePatientContact()
	{
		$this->json('POST', '/api/patientcontact',$this->updatedpatientcontactData);
		$response=$this->json('PUT', '/api/patientcontact');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",$response->original);
	}

	public function testDeletePatientContact()
	{
		$this->json('POST', '/api/patientcontact',$this->patientcontactData);
		$response=$this->delete('/api/patientcontact/1');
		$this->assertEquals(200,$response->getStatusCode());
		
	}

}