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

class MeasureTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
		$this->measureData=array(
			"measure_type_id"=>1,
			"name"=>'Sample String',
			"unit"=>'Sample String',
			"description"=>'Sample String',
		);
		$this->updatedMeasureData=array(
			"measure_type_id"=>1,
			"name"=>'Sample updated String',
			"unit"=>'Sample updated String',
			"description"=>'Sample updated String',
		);
	}

	public function testStoreMeasure()
	{
		$response=$this->json('POST', '/api/measure',$this->measureData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("description",$response->original);
	}

	public function testListMeasure()
	{
		$response=$this->json('GET', '/api/measure');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowMeasure()
	{
		$this->json('POST', '/api/measure',$this->measureData);
		$response=$this->json('GET', '/api/measure/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("description",$response->original);
	}

	public function testUpdateMeasure()
	{
		$this->json('POST', '/api/measure',$this->measureData);
		$response=$this->json('PUT', '/api/measure/1',$this->updatedMeasureData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("description",$response->original);
	}

	public function testDeleteMeasure()
	{
		$this->json('POST', '/api/measure',$this->measureData);
		$response=$this->delete('/api/measure/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}