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

class LotTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
	public function setVariables(){
		$this->lotData=array(
			"number"=>'Sample String',
			"description"=>'Sample String',
			"expiry"=>'2017:12:12 15:30:00',
			"instrument_id"=>1,
		);
		$this->updatedLotData=array(
			"number"=>'Sample updated String',
			"description"=>'Sample updated String',
			"expiry"=>'2016:12:12 15:30:00',
			"instrument_id"=>1,
		);
	}

	public function testStoreLot()
	{
		$response=$this->post('/api/lot',$this->lotData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("instrument_id",$response->original);
	}

	public function testListLot()
	{
		$response=$this->get('/api/lot');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowLot()
	{
		$response=$this->post('/api/lot',$this->lotData);
		$response=$this->get('/api/lot/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("instrument_id",$response->original);
	}

	public function testUpdateLot()
	{
		$response=$this->post('/api/lot',$this->lotData);
		$response=$this->put('/api/lot/1',$this->updatedLotData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("instrument_id",$response->original);
	}

	public function testDeleteLot()
	{
		$response=$this->post('/api/lot',$this->lotData);
		$response=$this->delete('/api/lot/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}