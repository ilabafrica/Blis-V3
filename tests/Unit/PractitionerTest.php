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
			"gender"=>1,
			"birth_date"=>'2017:12:12 15:30:00',"photo"=>'Sample String',

        );
    	$this->updatedpractitionerData=array(
        
			"created_by"=>1,
			"gender"=>1,
			"birth_date"=>'2016:12:12 15:30:00',"photo"=>'Sample updated String',

        );
	}

	public function testStorePractitioner()
	{
		$response=$this->json('POST', '/api/practitioner',$this->practitionerData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("created_by",$response);
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
	}

	public function testUpdatePractitioner()
	{
		$this->json('POST', '/api/practitioner',$this->practitionerData);
		$response=$this->json('PUT', '/api/practitioner/1',$this->updatedpractitionerData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("birth_date",$response->original);
	}

	public function testDeletePractitioner()
	{
		$this->json('POST', '/api/practitioner',$this->practitionerData);
		$response=$this->delete('/api/practitioner/1');
		$response->assertStatus(200);
		
	}

}