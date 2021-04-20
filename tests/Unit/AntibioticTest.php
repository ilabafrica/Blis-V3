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

class AntibioticTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
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
		$response=$this->post('/api/antibiotic',$this->antibioticData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testListAntibiotic()
	{
		$response=$this->get('/api/antibiotic');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowAntibiotic()
	{
		$response=$this->post('/api/antibiotic',$this->antibioticData);
		$response=$this->get('/api/antibiotic/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testUpdateAntibiotic()
	{
		$response=$this->post('/api/antibiotic',$this->antibioticData);
		$response=$this->put('/api/antibiotic/1',$this->updatedAntibioticData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testDeleteAntibiotic()
	{
		$response=$this->post('/api/antibiotic',$this->antibioticData);
		$response=$this->delete('/api/antibiotic/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}