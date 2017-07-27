<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PractitionerTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
    	$this->practitionerData=array(
        

			"created_by"=>1,
			"active"=>2,
			"name"=>'Sample',
			"telecom"=>1,
			"address"=>1234,
			"gender"=>1,
			"birth_date"=>'2017:12:12 15:30:00',
			"photo"=>'Sample String',


        );
    	$this->updatedpractitionerData=array(
        
			"created_by"=>1,
			"active"=>2,
			"name"=>'Sample Updated',
			"telecom"=>1,
			"address"=>12345,
			"gender"=>1,
			"birth_date"=>'2016:12:12 15:30:00',
			"photo"=>'Sample updated String',


        );
	}

	public function testStorePractitioner()
	{
		$response=$this->json('POST', '/api/practitioner',$this->practitionerData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("telecom",$response->original);
	}

	public function testListPractitioner()
	{
		$response=$this->json('GET', '/api/practitioner');
		$response->assertStatus(200);
		
	}

	public function testShowPractitioner()
	{
		$this->json('POST', '/api/practitioner',$this->practitionerData);
		$response=$this->json('GET', '/api/practitioner/1');
		$response->assertStatus(200);
		$this->assertArrayHasKey("birth_date",$response->original);
		$this->assertEquals($this->practitionerData['photo'], $response->original->photo);
	}

	public function testUpdatePractitioner()
	{
		$this->json('POST', '/api/practitioner',$this->practitionerData);
		$response=$this->json('PUT', '/api/practitioner/1',$this->updatedpractitionerData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("birth_date",$response->original);
		$this->assertEquals($this->updatedpractitionerData['photo'], $response->original->photo);
	}

	public function testDeletePractitioner()
	{
		$this->json('POST', '/api/practitioner',$this->practitionerData);
		$response=$this->delete('/api/practitioner/1');
		$response->assertStatus(200);
		$response=$this->json('GET', '/api/practitioner/1');
		$this->assertEquals(404, $response->getStatusCode());
		
	}
	public function testDeletePatientFail()
	{
		$response=$this->delete('/api/practitioner/9999999');
		$this->assertEquals(404, $response->getStatusCode());
	}

}