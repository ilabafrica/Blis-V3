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
		$response->assertStatus(200);
		$this->assertArrayHasKey("gender",$response->original);
	}

	public function testListPatientContact()
	{
		$response=$this->json('GET', '/api/patientcontact');
		$response->assertStatus(200);
		
	}

	public function testShowPatientContact()
	{
		$this->json('POST', '/api/patientcontact',$this->patientcontactData);
		$response=$this->json('GET', '/api/patientcontact/1');
		$response->assertStatus(200);
		$this->assertArrayHasKey("gender",$response->original);
	}

	public function testUpdatePatientContact()
	{
		$this->json('POST', '/api/patientcontact',$this->patientcontactData);
		$response=$this->json('PUT', '/api/patientcontact/1',$this->updatedpatientcontactData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("gender",$response->original);
	}

	public function testDeletePatientContact()
	{
		$this->json('POST', '/api/patientcontact',$this->patientcontactData);
		$response=$this->delete('/api/patientcontact/1');
		$response->assertStatus(200);
		
	}

}