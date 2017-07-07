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
        
			"language"=>1,

        );
    	$this->updatedpatientcommunicationData=array(
        
			"language"=>1,

        );
	}

	public function testStorePatientCommunication()
	{
		$response=$this->json('POST', '/api/patientcommunication',$this->patientcommunicationData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",[$response->original]);
	}

	public function testListPatientCommunication()
	{
		$response=$this->json('GET', '/api/patientcommunication');
		$this->assertEquals(200,$response->getStatusCode());
		
	}

	public function testShowPatientCommunication()
	{
		$this->json('POST', '/api/patientcommunication',$this->patientcommunicationData);
		$response=$this->json('GET', '/api/patientcommunication/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",$response->original);
	}

	public function testUpdatePatientCommunication()
	{
		$this->json('POST', '/api/patientcommunication',$this->updatedpatientcommunicationData);
		$response=$this->json('PUT', '/api/patientcommunication');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",$response->original);
	}

	public function testDeletePatientCommunication()
	{
		$this->json('POST', '/api/patientcommunication',$this->patientcommunicationData);
		$response=$this->delete('/api/patientcommunication/1');
		$this->assertEquals(200,$response->getStatusCode());
		
	}

}