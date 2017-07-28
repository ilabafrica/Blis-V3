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
        
			"accessionIdentifier"=>'BG1212',
            "status"=>1, //Codeable Concept Code e.g unsatisfactory
            "type"=>112, //Codeable Concept Code e.g Serum
            "subject"=>1, //patient ID
            "received_time"=>'2017:12:12 15:30:00',
            "parent"=>1, //Specimen id from which the specimen originated
            "note"=>'It is satisfactory', //comment

        );
    	$this->updatedspecimenData=array(
        
			"accessionIdentifier"=>'BG1212',
            "status"=>1, //Codeable Concept Code e.g unsatisfactory
            "type"=>12,
            "subject"=>1, //Codeable Concept Code e.g Serum
            "received_time"=>'2017:12:12 16:30:00',
            "parent"=>1, //Specimen id from which the specimen originated
            "note" => 'It is very satisfactory',

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
		$response = $this->json('GET','/api/specimen/1');
        $this->assertEquals(404, $response->getStatusCode());
		
	}
	public function testDeleteSpecimenFail()
    {
        $response =$this->delete('/api/specimen/999999999');
        $this->assertEquals(404, $response->getStatusCode());
    }

}