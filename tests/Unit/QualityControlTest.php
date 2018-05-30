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

class QualityControlTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
	public function setVariables(){
		$this->qualityControlData=array(
			"name"=>'Sample String',
			"description"=>'Sample String',
			"lot_id"=>1,
		);
		$this->updatedQualityControlData=array(
			"name"=>'Sample updated String',
			"description"=>'Sample updated String',
			"lot_id"=>1,
		);
	}

	public function testStoreQualityControl()
	{
		$response=$this->post('/api/qualitycontrol',$this->qualityControlData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("lot_id",$response->original);
	}

	public function testListQualityControl()
	{
		$response=$this->get('/api/qualitycontrol');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowQualityControl()
	{
		$response=$this->post('/api/qualitycontrol',$this->qualityControlData);
		$response=$this->get('/api/qualitycontrol/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("lot_id",$response->original);
	}

	public function testUpdateQualityControl()
	{
		$response=$this->post('/api/qualitycontrol',$this->qualityControlData);
		$response=$this->put('/api/qualitycontrol/1',$this->updatedQualityControlData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("lot_id",$response->original);
	}

	public function testDeleteQualityControl()
	{
		$response=$this->post('/api/qualitycontrol',$this->qualityControlData);
		$response=$this->delete('/api/qualitycontrol/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}