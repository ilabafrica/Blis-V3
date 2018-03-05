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

class MeasureTypeTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
		$this->measureTypeData=array(
			"code"=>'Sample String',
			"name"=>'Sample String',
		);
		$this->updatedMeasureTypeData=array(
			"code"=>'Sample updated String',
			"name"=>'Sample updated String',
		);
	}

	public function testStoreMeasureType()
	{
		$response=$this->json('POST', '/api/measuretype',$this->measureTypeData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testListMeasureType()
	{
		$response=$this->json('GET', '/api/measuretype');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowMeasureType()
	{
		$this->json('POST', '/api/measuretype',$this->measureTypeData);
		$response=$this->json('GET', '/api/measuretype/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testUpdateMeasureType()
	{
		$this->json('POST', '/api/measuretype',$this->measureTypeData);
		$response=$this->json('PUT', '/api/measuretype/1',$this->updatedMeasureTypeData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testDeleteMeasureType()
	{
		$this->json('POST', '/api/measuretype',$this->measureTypeData);
		$response=$this->delete('/api/measuretype/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}