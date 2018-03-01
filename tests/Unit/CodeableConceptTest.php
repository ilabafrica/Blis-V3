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

class CodeableConceptTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
		$this->codeableConceptData=array(
			"code"=>'Sample String',
			"text"=>'Sample String',
		);
		$this->updatedCodeableConceptData=array(
			"code"=>'Sample updated String',
			"text"=>'Sample updated String',
		);
	}

	public function testStoreCodeableConcept()
	{
		$response=$this->json('POST', '/api/codeableconcept',$this->codeableConceptData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("text",$response->original);
	}

	public function testListCodeableConcept()
	{
		$response=$this->json('GET', '/api/codeableconcept');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowCodeableConcept()
	{
		$this->json('POST', '/api/codeableconcept',$this->codeableConceptData);
		$response=$this->json('GET', '/api/codeableconcept/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("text",$response->original);
	}

	public function testUpdateCodeableConcept()
	{
		$this->json('POST', '/api/codeableconcept',$this->codeableConceptData);
		$response=$this->json('PUT', '/api/codeableconcept/1',$this->updatedCodeableConceptData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("text",$response->original);
	}

	public function testDeleteCodeableConcept()
	{
		$this->json('POST', '/api/codeableconcept',$this->codeableConceptData);
		$response=$this->delete('/api/codeableconcept/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}