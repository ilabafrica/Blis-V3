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

class InstrumentTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
	public function setVariables(){
		$this->instrumentData=array(
			"name"=>'Sample String',
		);
		$this->updatedInstrumentData=array(
			"name"=>'Sample updated String',
		);
	}

	public function testStoreInstrument()
	{
		$response=$this->post('/api/instrument',$this->instrumentData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testListInstrument()
	{
		$response=$this->get('/api/instrument');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowInstrument()
	{
		$response=$this->post('/api/instrument',$this->instrumentData);
		$response=$this->get('/api/instrument/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testUpdateInstrument()
	{
		$response=$this->post('/api/instrument',$this->instrumentData);
		$response=$this->put('/api/instrument/1',$this->updatedInstrumentData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testDeleteInstrument()
	{
		$response=$this->post('/api/instrument',$this->instrumentData);
		$response=$this->delete('/api/instrument/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}