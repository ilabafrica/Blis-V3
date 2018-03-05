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

class AntibioticTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
		$this->antibioticData=array(
			"code"=>'Sample String',
			"name"=>'Sample String',
		);
		$this->updatedAntibioticData=array(
			"code"=>'Sample updated String',
			"name"=>'Sample updated String',
		);
	}

	public function testStoreAntibiotic()
	{
		$response=$this->json('POST', '/api/antibiotic',$this->antibioticData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testListAntibiotic()
	{
		$response=$this->json('GET', '/api/antibiotic');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowAntibiotic()
	{
		$this->json('POST', '/api/antibiotic',$this->antibioticData);
		$response=$this->json('GET', '/api/antibiotic/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testUpdateAntibiotic()
	{
		$this->json('POST', '/api/antibiotic',$this->antibioticData);
		$response=$this->json('PUT', '/api/antibiotic/1',$this->updatedAntibioticData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testDeleteAntibiotic()
	{
		$this->json('POST', '/api/antibiotic',$this->antibioticData);
		$response=$this->delete('/api/antibiotic/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}