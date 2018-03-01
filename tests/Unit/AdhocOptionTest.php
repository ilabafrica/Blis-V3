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

class AdhocOptionTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
		$this->adhocOptionData=array(
			"adhoc_category_id"=>1,
			"code"=>'Sample String',
			"display"=>'Sample String',
		);
		$this->updatedAdhocOptionData=array(
			"adhoc_category_id"=>1,
			"code"=>'Sample updated String',
			"display"=>'Sample updated String',
		);
	}

	public function testStoreAdhocOption()
	{
		$response=$this->json('POST', '/api/adhocoption',$this->adhocOptionData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("display",$response->original);
	}

	public function testListAdhocOption()
	{
		$response=$this->json('GET', '/api/adhocoption');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowAdhocOption()
	{
		$this->json('POST', '/api/adhocoption',$this->adhocOptionData);
		$response=$this->json('GET', '/api/adhocoption/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("display",$response->original);
	}

	public function testUpdateAdhocOption()
	{
		$this->json('POST', '/api/adhocoption',$this->adhocOptionData);
		$response=$this->json('PUT', '/api/adhocoption/1',$this->updatedAdhocOptionData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("display",$response->original);
	}

	public function testDeleteAdhocOption()
	{
		$this->json('POST', '/api/adhocoption',$this->adhocOptionData);
		$response=$this->delete('/api/adhocoption/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}