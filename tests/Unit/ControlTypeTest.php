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

class ControlTypeTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
	public function setVariables(){
		$this->controlTypeData=array(
			"name"=>'Sample String',
			"description"=>'Sample String',
			"instrument_id"=>1,
		);
		$this->updatedControlTypeData=array(
			"name"=>'Sample updated String',
			"description"=>'Sample updated String',
			"instrument_id"=>1,
		);
	}

	public function testStoreControlType()
	{
		$response=$this->post('/api/controltype',$this->controlTypeData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("instrument_id",$response->original);
	}

	public function testListControlType()
	{
		$response=$this->get('/api/controltype');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowControlType()
	{
		$response=$this->post('/api/controltype',$this->controlTypeData);
		$response=$this->get('/api/controltype/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("instrument_id",$response->original);
	}

	public function testUpdateControlType()
	{
		$response=$this->post('/api/controltype',$this->controlTypeData);
		$response=$this->put('/api/controltype/1',$this->updatedControlTypeData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("instrument_id",$response->original);
	}

	public function testDeleteControlType()
	{
		$response=$this->post('/api/controltype',$this->controlTypeData);
		$response=$this->delete('/api/controltype/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}