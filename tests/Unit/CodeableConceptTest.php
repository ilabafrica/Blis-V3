<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CodeableConceptTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
    	$this->codeableconceptData=array(
        
			"code"=>'Sample String',
			"description"=>'Sample String',

        );
    	$this->updatedcodeableconceptData=array(
        
			"code"=>'Sample updated String',
			"description"=>'Sample updated String',

        );
	}

	public function testStoreCodeableConcept()
	{
		$response=$this->json('POST', '/api/codeableconcept',$this->codeableconceptData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",$response->original);
	}

	public function testListCodeableConcept()
	{
		$response=$this->json('GET', '/api/codeableconcept');
		$this->assertEquals(200,$response->getStatusCode());
		
	}

	public function testShowCodeableConcept()
	{
		$this->json('POST', '/api/codeableconcept',$this->codeableconceptData);
		$response=$this->json('GET', '/api/codeableconcept/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",$response->original);
	}

	public function testUpdateCodeableConcept()
	{
		$this->json('POST', '/api/codeableconcept',$this->updatedcodeableconceptData);
		$response=$this->json('PUT', '/api/codeableconcept');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",$response->original);
	}

	public function testDeleteCodeableConcept()
	{
		$this->json('POST', '/api/codeableconcept',$this->codeableconceptData);
		$response=$this->delete('/api/codeableconcept/1');
		$this->assertEquals(200,$response->getStatusCode());
		
	}

}