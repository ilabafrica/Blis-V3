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

class SusceptibilityRangeTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
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
		$response=$this->post('/api/susceptibilityrange',$this->susceptibilityRangeData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testListSusceptibilityRange()
	{
		$response=$this->get('/api/susceptibilityrange');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowSusceptibilityRange()
	{
		$response=$this->post('/api/susceptibilityrange',$this->susceptibilityRangeData);
		$response=$this->get('/api/susceptibilityrange/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testUpdateSusceptibilityRange()
	{
		$response=$this->post('/api/susceptibilityrange',$this->susceptibilityRangeData);
		$response=$this->put('/api/susceptibilityrange/1',$this->updatedSusceptibilityRangeData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testDeleteSusceptibilityRange()
	{
		$response=$this->post('/api/susceptibilityrange',$this->susceptibilityRangeData);
		$response=$this->delete('/api/susceptibilityrange/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}