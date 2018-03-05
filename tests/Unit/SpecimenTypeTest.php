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

class SpecimenTypeTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
		$this->specimenTypeData=array(
			"code"=>'Sample String',
			"name"=>'Sample String',
		);
		$this->updatedSpecimenTypeData=array(
			"code"=>'Sample updated String',
			"name"=>'Sample updated String',
		);
	}

	public function testStoreSpecimenType()
	{
		$response=$this->json('POST', '/api/specimentype',$this->specimenTypeData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testListSpecimenType()
	{
		$response=$this->json('GET', '/api/specimentype');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowSpecimenType()
	{
		$this->json('POST', '/api/specimentype',$this->specimenTypeData);
		$response=$this->json('GET', '/api/specimentype/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testUpdateSpecimenType()
	{
		$this->json('POST', '/api/specimentype',$this->specimenTypeData);
		$response=$this->json('PUT', '/api/specimentype/1',$this->updatedSpecimenTypeData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testDeleteSpecimenType()
	{
		$this->json('POST', '/api/specimentype',$this->specimenTypeData);
		$response=$this->delete('/api/specimentype/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}