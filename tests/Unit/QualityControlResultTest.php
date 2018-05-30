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

class QualityControlResultTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
	public function setVariables(){
		$this->qualityControlResultData=array(
			"results"=>'Sample String',
			"control_measure_id"=>1,
			"control_test_id"=>1,
		);
		$this->updatedQualityControlResultData=array(
			"results"=>'Sample updated String',
			"control_measure_id"=>1,
			"control_test_id"=>1,
		);
	}

	public function testStoreQualityControlResult()
	{
		$response=$this->post('/api/qualitycontrolresult',$this->qualityControlResultData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("control_test_id",$response->original);
	}

	public function testListQualityControlResult()
	{
		$response=$this->get('/api/qualitycontrolresult');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowQualityControlResult()
	{
		$response=$this->post('/api/qualitycontrolresult',$this->qualityControlResultData);
		$response=$this->get('/api/qualitycontrolresult/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("control_test_id",$response->original);
	}

	public function testUpdateQualityControlResult()
	{
		$response=$this->post('/api/qualitycontrolresult',$this->qualityControlResultData);
		$response=$this->put('/api/qualitycontrolresult/1',$this->updatedQualityControlResultData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("control_test_id",$response->original);
	}

	public function testDeleteQualityControlResult()
	{
		$response=$this->post('/api/qualitycontrolresult',$this->qualityControlResultData);
		$response=$this->delete('/api/qualitycontrolresult/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}