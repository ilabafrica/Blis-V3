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

class TelecomTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
	public function setVariables(){
		$this->telecomData=array(
			"patient_id"=>1,
			"system"=>'Sample String',
			"value"=>'Sample String',
			"use"=>'Sample String',
			"rank"=>1,
		);
		$this->updatedTelecomData=array(
			"patient_id"=>1,
			"system"=>'Sample updated String',
			"value"=>'Sample updated String',
			"use"=>'Sample updated String',
			"rank"=>1,
		);
	}

	public function testStoreTelecom()
	{
		$response=$this->post('/api/telecom',$this->telecomData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("rank",$response->original);
	}

	public function testListTelecom()
	{
		$response=$this->get('/api/telecom');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowTelecom()
	{
		$response=$this->post('/api/telecom',$this->telecomData);
		$response=$this->get('/api/telecom/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("rank",$response->original);
	}

	public function testUpdateTelecom()
	{
		$response=$this->post('/api/telecom',$this->telecomData);
		$response=$this->put('/api/telecom/1',$this->updatedTelecomData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("rank",$response->original);
	}

	public function testDeleteTelecom()
	{
		$response=$this->post('/api/telecom',$this->telecomData);
		$response=$this->delete('/api/telecom/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}