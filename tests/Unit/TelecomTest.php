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

class TelecomTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

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
		$response=$this->json('POST', '/api/telecom',$this->telecomData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("rank",$response->original);
	}

	public function testListTelecom()
	{
		$response=$this->json('GET', '/api/telecom');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowTelecom()
	{
		$this->json('POST', '/api/telecom',$this->telecomData);
		$response=$this->json('GET', '/api/telecom/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("rank",$response->original);
	}

	public function testUpdateTelecom()
	{
		$this->json('POST', '/api/telecom',$this->telecomData);
		$response=$this->json('PUT', '/api/telecom/1',$this->updatedTelecomData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("rank",$response->original);
	}

	public function testDeleteTelecom()
	{
		$this->json('POST', '/api/telecom',$this->telecomData);
		$response=$this->delete('/api/telecom/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}