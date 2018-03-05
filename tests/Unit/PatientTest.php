<?php
namespace Tests\Unit;
/**
 * (c) @iLabAfrica
 * BLIS			 - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead	 - Emmanuel Kweyu.
 * Devs			 - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma|Anthony Ereng
 */

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
			"identifier"=>'Sample String',
			"active"=>'Sample String',
			"name_id"=>1,
			"telecom_id"=>1,
			"gender_id"=>1,
			"birth_date"=>'2017:12:12 15:30:00',
			"deceased"=>'Sample String',
			"deceased_date_time"=>'2017:12:12 15:30:00',
			"address_id"=>1,
			"marital_status"=>1,
			"photo"=>'Sample String',
			"animal"=>'Sample String',
			"species_id"=>1,
			"breed_id"=>1,
			"gender_status"=>'Sample String',
			"practitioner_id"=>1,
			"organization_id"=>1,
			"created_by"=>1,
		);
		$this->updatedPatientData=array(
			"identifier"=>'Sample updated String',
			"active"=>'Sample updated String',
			"name_id"=>1,
			"telecom_id"=>1,
			"gender_id"=>1,
			"birth_date"=>'2016:12:12 15:30:00',
			"deceased"=>'Sample updated String',
			"deceased_date_time"=>'2016:12:12 15:30:00',
			"address_id"=>1,
			"marital_status"=>1,
			"photo"=>'Sample updated String',
			"animal"=>'Sample updated String',
			"species_id"=>1,
			"breed_id"=>1,
			"gender_status"=>'Sample updated String',
			"practitioner_id"=>1,
			"organization_id"=>1,
			"created_by"=>1,
		);
	}

	public function testStorePatient()
	{
		$response=$this->json('POST', '/api/patient',$this->patientData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("created_by",$response->original);
	}

	public function testListPatient()
	{
		$response=$this->json('GET', '/api/patient');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowPatient()
	{
		$this->json('POST', '/api/patient',$this->patientData);
		$response=$this->json('GET', '/api/patient/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("created_by",$response->original);
	}

	public function testUpdatePatient()
	{
		$this->json('POST', '/api/patient',$this->patientData);
		$response=$this->json('PUT', '/api/patient/1',$this->updatedPatientData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("created_by",$response->original);
	}

	public function testDeletePatient()
	{
		$this->json('POST', '/api/patient',$this->patientData);
		$response=$this->delete('/api/patient/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}