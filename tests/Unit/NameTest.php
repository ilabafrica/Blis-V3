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

class NameTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
		$this->nameData=array(
			"use"=>'Sample String',
			"text"=>'Sample String',
			"family"=>'Sample String',
			"given"=>'Sample String',
			"prefix"=>'Sample String',
			"suffix"=>'Sample String',
		);
		$this->updatedNameData=array(
			"use"=>'Sample updated String',
			"text"=>'Sample updated String',
			"family"=>'Sample updated String',
			"given"=>'Sample updated String',
			"prefix"=>'Sample updated String',
			"suffix"=>'Sample updated String',
		);
	}

	public function testStoreName()
	{
		$response=$this->json('POST', '/api/name',$this->nameData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("suffix",$response->original);
	}

	public function testListName()
	{
		$response=$this->json('GET', '/api/name');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowName()
	{
		$this->json('POST', '/api/name',$this->nameData);
		$response=$this->json('GET', '/api/name/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("suffix",$response->original);
	}

	public function testUpdateName()
	{
		$this->json('POST', '/api/name',$this->nameData);
		$response=$this->json('PUT', '/api/name/1',$this->updatedNameData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("suffix",$response->original);
	}

	public function testDeleteName()
	{
		$this->json('POST', '/api/name',$this->nameData);
		$response=$this->delete('/api/name/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}