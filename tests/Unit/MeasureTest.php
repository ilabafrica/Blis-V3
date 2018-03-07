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

class MeasureTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
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
		$response=$this->post('/api/measure',$this->measureData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("description",$response->original);
	}

	public function testListMeasure()
	{
		$response=$this->get('/api/measure');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowMeasure()
	{
		$response=$this->post('/api/measure',$this->measureData);
		$response=$this->get('/api/measure/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("description",$response->original);
	}

	public function testUpdateMeasure()
	{
		$response=$this->post('/api/measure',$this->measureData);
		$response=$this->put('/api/measure/1',$this->updatedMeasureData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("description",$response->original);
	}

	public function testDeleteMeasure()
	{
		$response=$this->post('/api/measure',$this->measureData);
		$response=$this->delete('/api/measure/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}