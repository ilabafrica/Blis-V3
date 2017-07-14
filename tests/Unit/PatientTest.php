<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PatientTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
    	$this->patientData=array(
        
			"created_by"=>1,
			"active"=>1,
			"identifier"=>1,
			"gender"=>1,
			"name" => "s",
			"address"=>"ss",
			"birth_date"=>'2017:12:12 15:30:00',
			"marital_status"=>1,
			"photo"=>'Sample String',
			"animal_species"=>'Sample String',
			"animal_breed"=>'Sample String',
			"animal_gender_status"=>'Sample String',

        );
    	$this->updatedpatientData=array(
        
			"created_by"=>1,
			"active"=>1,
			"identifier"=>1,
			"gender"=>1,
			"name" => "b",
			"address"=>"bb",
			"birth_date"=>'2016:12:12 15:30:00',
			"marital_status"=>1,
			"photo"=>'Sample updated String',
			"animal_species"=>'Sample updated String',
			"animal_breed"=>'Sample updated String',
			"animal_gender_status"=>'Sample updated String',

        );
	}

	public function testStorePatient()
	{
		$response=$this->json('POST', '/api/patient',$this->patientData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("created_by", $response->original);
	}

	public function testListPatient()
	{
		$response=$this->json('GET', '/api/patient');
		$response->assertStatus(200);
	}

	public function testShowPatient()
	{
		$this->json('POST', '/api/patient',$this->patientData);
		$response=$this->json('GET', '/api/patient/1');
		$response->assertStatus(200);
		$this->assertArrayHasKey("created_by",$response->original);
	}

	public function testUpdatePatient()
	{
		$this->json('POST', '/api/patient',$this->updatedpatientData);
		$response = $this->json('PUT', '/api/patient');
		$response->assertStatus(200);
		$this->assertArrayHasKey("subject",[$response->original]);
	}

	public function testDeletePatient()
	{
		$this->json('POST', '/api/patient',$this->patientData);
		$response=$this->delete('/api/patient/1');
		$this->assertEquals(200,$response->getStatusCode());
		
	}

}