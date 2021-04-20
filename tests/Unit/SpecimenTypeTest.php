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

class SpecimenTypeTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
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
		$response=$this->post('/api/specimentype',$this->specimenTypeData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testListSpecimenType()
	{
		$response=$this->get('/api/specimentype');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowSpecimenType()
	{
		$response=$this->post('/api/specimentype',$this->specimenTypeData);
		$response=$this->get('/api/specimentype/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testUpdateSpecimenType()
	{
		$response=$this->post('/api/specimentype',$this->specimenTypeData);
		$response=$this->put('/api/specimentype/1',$this->updatedSpecimenTypeData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testDeleteSpecimenType()
	{
		$response=$this->post('/api/specimentype',$this->specimenTypeData);
		$response=$this->delete('/api/specimentype/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}