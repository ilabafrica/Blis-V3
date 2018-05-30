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

class QualityControlMeasureRangeTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
	public function setVariables(){
		$this->qualityControlMeasureRangeData=array(
			"upper_range"=>'Sample String',
			"lower_range"=>'Sample String',
			"alphanumeric"=>'Sample String',
			"control_measure_id"=>1,
		);
		$this->updatedQualityControlMeasureRangeData=array(
			"upper_range"=>'Sample updated String',
			"lower_range"=>'Sample updated String',
			"alphanumeric"=>'Sample updated String',
			"control_measure_id"=>1,
		);
	}

	public function testStoreQualityControlMeasureRange()
	{
		$response=$this->post('/api/qualitycontrolmeasurerange',$this->qualityControlMeasureRangeData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("control_measure_id",$response->original);
	}

	public function testListQualityControlMeasureRange()
	{
		$response=$this->get('/api/qualitycontrolmeasurerange');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowQualityControlMeasureRange()
	{
		$response=$this->post('/api/qualitycontrolmeasurerange',$this->qualityControlMeasureRangeData);
		$response=$this->get('/api/qualitycontrolmeasurerange/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("control_measure_id",$response->original);
	}

	public function testUpdateQualityControlMeasureRange()
	{
		$response=$this->post('/api/qualitycontrolmeasurerange',$this->qualityControlMeasureRangeData);
		$response=$this->put('/api/qualitycontrolmeasurerange/1',$this->updatedQualityControlMeasureRangeData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("control_measure_id",$response->original);
	}

	public function testDeleteQualityControlMeasureRange()
	{
		$response=$this->post('/api/qualitycontrolmeasurerange',$this->qualityControlMeasureRangeData);
		$response=$this->delete('/api/qualitycontrolmeasurerange/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}