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

class QualityControlTestTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
	public function setVariables(){
		$this->qualityControlTestData=array(
			"entered_by"=>1,
			"control_id"=>1,
		);
		$this->updatedQualityControlTestData=array(
			"entered_by"=>1,
			"control_id"=>1,
		);
	}

	public function testStoreQualityControlTest()
	{
		$response=$this->post('/api/qualitycontroltest',$this->qualityControlTestData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("control_id",$response->original);
	}

	public function testListQualityControlTest()
	{
		$response=$this->get('/api/qualitycontroltest');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowQualityControlTest()
	{
		$response=$this->post('/api/qualitycontroltest',$this->qualityControlTestData);
		$response=$this->get('/api/qualitycontroltest/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("control_id",$response->original);
	}

	public function testUpdateQualityControlTest()
	{
		$response=$this->post('/api/qualitycontroltest',$this->qualityControlTestData);
		$response=$this->put('/api/qualitycontroltest/1',$this->updatedQualityControlTestData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("control_id",$response->original);
	}

	public function testDeleteQualityControlTest()
	{
		$response=$this->post('/api/qualitycontroltest',$this->qualityControlTestData);
		$response=$this->delete('/api/qualitycontroltest/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}