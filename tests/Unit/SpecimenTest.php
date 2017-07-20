<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SpecimenTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
    	$this->specimenData=array(
        
			"status"=>1,
			"type"=>1,
			"note"=>'Sample String',

        );
    	$this->updatedspecimenData=array(
        
			"status"=>1,
			"type"=>1,
			"note"=>'Sample updated String',

        );
	}

	public function testStoreSpecimen()
	{
		$response=$this->json('POST', '/api/specimen',$this->specimenData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("note",$response->original);
	}

	public function testListSpecimen()
	{
		$response=$this->json('GET', '/api/specimen');
		$response->assertStatus(200);
		
	}

	public function testShowSpecimen()
	{
		$this->json('POST', '/api/specimen',$this->specimenData);
		$response=$this->json('GET', '/api/specimen/1');
		$response->assertStatus(200);
		$this->assertArrayHasKey("note",$response->original);
	}

	public function testUpdateSpecimen()
	{
		$this->json('POST', '/api/specimen',$this->specimenData);
		$response=$this->json('PUT', '/api/specimen/1',$this->updatedspecimenData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("note",$response->original);
	}

	public function testDeleteSpecimen()
	{
		$this->json('POST', '/api/specimen',$this->specimenData);
		$response=$this->delete('/api/specimen/1');
		$response->assertStatus(200);
		
	}

}