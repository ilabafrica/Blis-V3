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

class ControlMeasureTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
	public function setVariables(){
		$this->controlMeasureData=array(
			"name"=>'Sample String',
			"unit"=>'Sample String',
			"control_type_id"=>1,
			"measure_type_id"=>1,
		);
		$this->updatedControlMeasureData=array(
			"name"=>'Sample updated String',
			"unit"=>'Sample updated String',
			"control_type_id"=>1,
			"measure_type_id"=>1,
		);
	}

	public function testStoreControlMeasure()
	{
		$response=$this->post('/api/controlmeasure',$this->controlMeasureData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("measure_type_id",$response->original);
	}

	public function testListControlMeasure()
	{
		$response=$this->get('/api/controlmeasure');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowControlMeasure()
	{
		$response=$this->post('/api/controlmeasure',$this->controlMeasureData);
		$response=$this->get('/api/controlmeasure/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("measure_type_id",$response->original);
	}

	public function testUpdateControlMeasure()
	{
		$response=$this->post('/api/controlmeasure',$this->controlMeasureData);
		$response=$this->put('/api/controlmeasure/1',$this->updatedControlMeasureData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("measure_type_id",$response->original);
	}

	public function testDeleteControlMeasure()
	{
		$response=$this->post('/api/controlmeasure',$this->controlMeasureData);
		$response=$this->delete('/api/controlmeasure/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}