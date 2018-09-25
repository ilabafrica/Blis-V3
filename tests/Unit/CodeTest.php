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

class CodeTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
	public function setVariables(){
		$this->codeData=array(
			"code_system_id"=>'Sample String',
			"code"=>'Sample String',
			"display"=>'Sample String',
			"description"=>'Sample String',
		);
		$this->updatedCodeData=array(
			"code_system_id"=>'Sample updated String',
			"code"=>'Sample updated String',
			"display"=>'Sample updated String',
			"description"=>'Sample updated String',
		);
	}

	public function testStoreCode()
	{
		$response=$this->post('/api/code',$this->codeData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("description",$response->original);
	}

	public function testListCode()
	{
		$response=$this->get('/api/code');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowCode()
	{
		$response=$this->post('/api/code',$this->codeData);
		$response=$this->get('/api/code/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("description",$response->original);
	}

	public function testUpdateCode()
	{
		$response=$this->post('/api/code',$this->codeData);
		$response=$this->put('/api/code/1',$this->updatedCodeData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("description",$response->original);
	}

	public function testDeleteCode()
	{
		$response=$this->post('/api/code',$this->codeData);
		$response=$this->delete('/api/code/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}