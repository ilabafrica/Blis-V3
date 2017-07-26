<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PatientCommunicationTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
    	$this->patientcommunicationData=array(
            
            "patient_id"=>1,
			"language"=>1,
			"preferred"=>'Sample',

        );
    	$this->updatedpatientcommunicationData=array(
        
			"patient_id"=>1,
			"language"=>1,
			"preferred"=>'Sample updated',

        );
	}

	public function testStorePatientCommunication()
	{
		$response=$this->json('POST', '/api/patientcommunication',$this->patientcommunicationData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("language",$response->original);
	}

	public function testListPatientCommunication()
	{
		$response=$this->json('GET', '/api/patientcommunication');
		$response->assertStatus(200);
		
	}

	public function testShowPatientCommunication()
	{
		$this->json('POST', '/api/patientcommunication',$this->patientcommunicationData);
		$response=$this->json('GET', '/api/patientcommunication/1');
		$response->assertStatus(200);
		$this->assertArrayHasKey("language",$response->original);
	}

	public function testUpdatePatientCommunication()
	{
		$this->json('POST', '/api/patientcommunication',$this->patientcommunicationData);
		$response=$this->json('PUT', '/api/patientcommunication/1',$this->updatedpatientcommunicationData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("language",$response->original);
	}

	public function testDeletePatientCommunication()
	{
		$this->json('POST', '/api/patientcommunication',$this->patientcommunicationData);
		$response=$this->delete('/api/patientcommunication/1');
		$response->assertStatus(200);
		$response=$this->json('GET', '/api/patientcommunication/1');
		$this->assertEquals(404, $response->getStatusCode());
		
	}

	public function testDeletePatientCommunicationFail()
	{
		$response=$this->delete('/api/patientcommunication/9999999999');
		$this->assertEquals(404, $response->getStatusCode());
	}

}