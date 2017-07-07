<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PatientLinkTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
    	$this->patientlinkData=array(
        
			"type"=>1,

        );
    	$this->updatedpatientlinkData=array(
        
			"type"=>1,

        );
	}

	public function testStorePatientLink()
	{
		$response=$this->json('POST', '/api/patientlink',$this->patientlinkData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",[$response->original]);
	}

	public function testListPatientLink()
	{
		$response=$this->json('GET', '/api/patientlink');
		$this->assertEquals(200,$response->getStatusCode());
		
	}

	public function testShowPatientLink()
	{
		$this->json('POST', '/api/patientlink',$this->patientlinkData);
		$response=$this->json('GET', '/api/patientlink/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",$response->original);
	}

	public function testUpdatePatientLink()
	{
		$this->json('POST', '/api/patientlink',$this->updatedpatientlinkData);
		$response=$this->json('PUT', '/api/patientlink');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",$response->original);
	}

	public function testDeletePatientLink()
	{
		$this->json('POST', '/api/patientlink',$this->patientlinkData);
		$response=$this->delete('/api/patientlink/1');
		$this->assertEquals(200,$response->getStatusCode());
		
	}

}