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

class InterpretationTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
		$this->interpretationData=array(
			"code"=>'Sample String',
			"name"=>1,
		);
		$this->updatedInterpretationData=array(
			"code"=>'Sample updated String',
			"name"=>1,
		);
	}

	public function testStoreInterpretation()
	{
		$response=$this->json('POST', '/api/interpretation',$this->interpretationData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testListInterpretation()
	{
		$response=$this->json('GET', '/api/interpretation');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowInterpretation()
	{
		$this->json('POST', '/api/interpretation',$this->interpretationData);
		$response=$this->json('GET', '/api/interpretation/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testUpdateInterpretation()
	{
		$this->json('POST', '/api/interpretation',$this->interpretationData);
		$response=$this->json('PUT', '/api/interpretation/1',$this->updatedInterpretationData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testDeleteInterpretation()
	{
		$this->json('POST', '/api/interpretation',$this->interpretationData);
		$response=$this->delete('/api/interpretation/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}