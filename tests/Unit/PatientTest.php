<?php
namespace Tests\Unit;
/**
 * (c) @iLabAfrica
 * BLIS			 - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead	 - Emmanuel Kweyu.
 * Devs			 - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma|Anthony Ereng
 */

use Tests\SetUp;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PatientTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
	public function setVariables(){
		$this->patientData=array(
			"identifier"=>'Sample updated String',
			"active"=>'Sample updated String',
			"name" => "Given Name",
			"name_id"=>1,
			"gender_id"=>1,
			"deceased"=>'Sample updated String',
			"deceased_date_time"=>'2016:12:12 15:30:00',
			"address_id"=>1,
			"marital_status"=>1,
			"photo"=>'Sample updated String',
			"animal"=>'Sample updated String',
			"species_id"=>1,
			"breed_id"=>1,
			"gender" => "Male",
			"birth_date" => "1977-05-18",
			"given" => "Given",
			"family" => "Family",
			"gender_status"=>'Sample updated String',
			"practitioner_id"=>1,
			"organization_id"=>1,
			"created_by"=>1,
		);
	}

	public function testStorePatient()
	{
		$response=$this->post('/api/patient',$this->patientData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("created_by",$response->original);
	}

	public function testListPatient()
	{
		$response=$this->get('/api/patient');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowPatient()
	{
		$response=$this->post('/api/patient',$this->patientData);
		$response=$this->get('/api/patient/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("created_by",$response->original);
	}

	public function testUpdatePatient()
	{
		$store=$this->post('/api/patient',$this->patientData);
		$update=$this->put('/api/patient/'.$store->original->id,[
		  'id' => 1,
		  'identifier' => 'yjacobi@example.com',
		  'active' => 1,
		  'name_id' => 1,
		  'gender_id' => 1,
		  'birth_date' => '1997-06-19',
		  'deceased' => 0,
		  'deceased_date_time' => NULL,
		  'address_id' => NULL,
		  'marital_status' => 11,
		  'photo' => NULL,
		  'animal' => 0,
		  'species_id' => NULL,
		  'breed_id' => NULL,
		  'gender_status' => NULL,
		  'practitioner_id' => NULL,
		  'organization_id' => NULL,
		  'created_by' => 32,
		  'created_at' => '2018-06-19 10:38:02',
		  'updated_at' => '2018-06-19 10:38:02',
		  'name' => 
		  [
		    'id' => 1,
		    'use' => 'modi',
		    'text' => 'consectetur',
		    'family' => 'dolor',
		    'given' => 'laboriosam',
		    'prefix' => 'eos',
		    'suffix' => 'nisi',
		    'created_at' => '2018-06-19 10:37:59',
		    'updated_at' => '2018-06-19 10:37:59',
		  ],
		  'gender' => 
		  [
		    'id' => 1,
		    'code' => 'Male',
		    'display' => 'Male',
		  ],
		]);
		$this->assertEquals(200,$update->getStatusCode());
		$this->assertArrayHasKey("created_by",$update->original);
	}

	public function testDeletePatient()
	{
		$response=$this->post('/api/patient',$this->patientData);
		$response=$this->delete('/api/patient/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}