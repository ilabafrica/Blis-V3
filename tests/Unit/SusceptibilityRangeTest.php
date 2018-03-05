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

class SusceptibilityRangeTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
		$this->susceptibilityRangeData=array(
			"code"=>'Sample String',
			"name"=>'Sample String',
		);
		$this->updatedSusceptibilityRangeData=array(
			"code"=>'Sample updated String',
			"name"=>'Sample updated String',
		);
	}

	public function testStoreSusceptibilityRange()
	{
		$response=$this->json('POST', '/api/susceptibilityrange',$this->susceptibilityRangeData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testListSusceptibilityRange()
	{
		$response=$this->json('GET', '/api/susceptibilityrange');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowSusceptibilityRange()
	{
		$this->json('POST', '/api/susceptibilityrange',$this->susceptibilityRangeData);
		$response=$this->json('GET', '/api/susceptibilityrange/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testUpdateSusceptibilityRange()
	{
		$this->json('POST', '/api/susceptibilityrange',$this->susceptibilityRangeData);
		$response=$this->json('PUT', '/api/susceptibilityrange/1',$this->updatedSusceptibilityRangeData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testDeleteSusceptibilityRange()
	{
		$this->json('POST', '/api/susceptibilityrange',$this->susceptibilityRangeData);
		$response=$this->delete('/api/susceptibilityrange/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}