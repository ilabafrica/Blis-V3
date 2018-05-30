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

class QualityControlMeasureTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
	public function setVariables(){
		$this->qualityControlMeasureData=array(
			"name"=>'Sample String',
			"unit"=>'Sample String',
			"control_id"=>1,
			"control_measure_type_id"=>1,
		);
		$this->updatedQualityControlMeasureData=array(
			"name"=>'Sample updated String',
			"unit"=>'Sample updated String',
			"control_id"=>1,
			"control_measure_type_id"=>1,
		);
	}

	public function testStoreQualityControlMeasure()
	{
		$response=$this->post('/api/qualitycontrolmeasure',$this->qualityControlMeasureData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("control_measure_type_id",$response->original);
	}

	public function testListQualityControlMeasure()
	{
		$response=$this->get('/api/qualitycontrolmeasure');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowQualityControlMeasure()
	{
		$response=$this->post('/api/qualitycontrolmeasure',$this->qualityControlMeasureData);
		$response=$this->get('/api/qualitycontrolmeasure/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("control_measure_type_id",$response->original);
	}

	public function testUpdateQualityControlMeasure()
	{
		$response=$this->post('/api/qualitycontrolmeasure',$this->qualityControlMeasureData);
		$response=$this->put('/api/qualitycontrolmeasure/1',$this->updatedQualityControlMeasureData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("control_measure_type_id",$response->original);
	}

	public function testDeleteQualityControlMeasure()
	{
		$response=$this->post('/api/qualitycontrolmeasure',$this->qualityControlMeasureData);
		$response=$this->delete('/api/qualitycontrolmeasure/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}