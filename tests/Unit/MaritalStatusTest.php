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

class MaritalStatusTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
		$this->maritalStatusData=array(
			"code"=>'Sample String',
			"display"=>'Sample String',
			"definition"=>'Sample String',
		);
		$this->updatedMaritalStatusData=array(
			"code"=>'Sample updated String',
			"display"=>'Sample updated String',
			"definition"=>'Sample updated String',
		);
	}

	public function testStoreMaritalStatus()
	{
		$response=$this->json('POST', '/api/maritalstatus',$this->maritalStatusData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("definition",$response->original);
	}

	public function testListMaritalStatus()
	{
		$response=$this->json('GET', '/api/maritalstatus');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowMaritalStatus()
	{
		$this->json('POST', '/api/maritalstatus',$this->maritalStatusData);
		$response=$this->json('GET', '/api/maritalstatus/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("definition",$response->original);
	}

	public function testUpdateMaritalStatus()
	{
		$this->json('POST', '/api/maritalstatus',$this->maritalStatusData);
		$response=$this->json('PUT', '/api/maritalstatus/1',$this->updatedMaritalStatusData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("definition",$response->original);
	}

	public function testDeleteMaritalStatus()
	{
		$this->json('POST', '/api/maritalstatus',$this->maritalStatusData);
		$response=$this->delete('/api/maritalstatus/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}