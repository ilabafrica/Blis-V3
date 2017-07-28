<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PractitionerCommunicationTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
    	$this->practitionercommunicationData=array(

            "practitioner_id"=>1,
            "patient_id"=>1,
			"language"=>1,
			"preferred"=>12,

        );
    	$this->updatedpractitionercommunicationData=array(
            
            "practitioner_id"=>1,
            "patient_id"=>1,
			"language"=>1,
			"preferred"=>12,

        );
	}

	public function testStorePractitionerCommunication()
	{
		$response=$this->json('POST', '/api/practitionercommunication',$this->practitionercommunicationData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("language",$response->original);
	}

	public function testListPractitionerCommunication()
	{
		$response=$this->json('GET', '/api/practitionercommunication');
		$response->assertStatus(200);
		
	}

	public function testShowPractitionerCommunication()
	{
		$this->json('POST', '/api/practitionercommunication',$this->practitionercommunicationData);
		$response=$this->json('GET', '/api/practitionercommunication/1');
		$response->assertStatus(200);
		$this->assertArrayHasKey("language",$response->original);
	}

	public function testUpdatePractitionerCommunication()
	{
		$this->json('POST', '/api/practitionercommunication',$this->practitionercommunicationData);
		$response=$this->json('PUT', '/api/practitionercommunication/1',$this->updatedpractitionercommunicationData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("language",$response->original);
	}

	public function testDeletePractitionerCommunication()
	{
		$this->json('POST', '/api/practitionercommunication',$this->practitionercommunicationData);
		$response=$this->delete('/api/practitionercommunication/1');
		$response->assertStatus(200);
		$response=$this->json('GET', '/api/practitionercommunication/1');
		$this->assertEquals(404, $response->getStatusCode());
		
	}
	public function testDeletePractitionerCommunicationFail()
	{
		$response=$this->delete('/api/patient/9999999999');
		$this->assertEquals(404, $response->getStatusCode());
	}

}