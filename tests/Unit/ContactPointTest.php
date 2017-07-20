<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ContactPointTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
    	$this->contactpointData=array(
        
			"user_id"=>1,
			"system"=>1,
			"value"=>'Sample String',
			"use"=>1,
			"rank"=>1,
			"period"=>'2017:12:12 15:30:00',
        );
    	$this->updatedcontactpointData=array(
        
			"user_id"=>1,
			"system"=>1,
			"value"=>'Sample updated String',
			"use"=>1,
			"rank"=>1,
			"period"=>'2016:12:12 15:30:00',
        );
	}

	public function testStoreContactPoint()
	{
		$response=$this->json('POST', '/api/contactpoint',$this->contactpointData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("value",$response->original);
	}

	public function testListContactPoint()
	{
		$response=$this->json('GET', '/api/contactpoint');
		$response->assertStatus(200);
		
	}

	public function testShowContactPoint()
	{
		$this->json('POST', '/api/contactpoint',$this->contactpointData);
		$response=$this->json('GET', '/api/contactpoint/1');
		$response->assertStatus(200);
		$this->assertArrayHasKey("value",$response->original);
	}

	public function testUpdateContactPoint()
	{
		$this->json('POST', '/api/contactpoint',$this->contactpointData);
		$response=$this->json('PUT', '/api/contactpoint/1',$this->updatedcontactpointData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("value",$response->original);
	}

	public function testDeleteContactPoint()
	{
		$this->json('POST', '/api/contactpoint',$this->contactpointData);
		$response=$this->delete('/api/contactpoint/1');
		$response->assertStatus(200);
		
	}

}