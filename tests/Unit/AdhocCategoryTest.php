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

class AdhocCategoryTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
		$this->adhocCategoryData=array(
			"code"=>'Sample String',
			"display"=>'Sample String',
		);
		$this->updatedAdhocCategoryData=array(
			"code"=>'Sample updated String',
			"display"=>'Sample updated String',
		);
	}

	public function testStoreAdhocCategory()
	{
		$response=$this->json('POST', '/api/adhoccategory',$this->adhocCategoryData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("display",$response->original);
	}

	public function testListAdhocCategory()
	{
		$response=$this->json('GET', '/api/adhoccategory');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowAdhocCategory()
	{
		$this->json('POST', '/api/adhoccategory',$this->adhocCategoryData);
		$response=$this->json('GET', '/api/adhoccategory/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("display",$response->original);
	}

	public function testUpdateAdhocCategory()
	{
		$this->json('POST', '/api/adhoccategory',$this->adhocCategoryData);
		$response=$this->json('PUT', '/api/adhoccategory/1',$this->updatedAdhocCategoryData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("display",$response->original);
	}

	public function testDeleteAdhocCategory()
	{
		$this->json('POST', '/api/adhoccategory',$this->adhocCategoryData);
		$response=$this->delete('/api/adhoccategory/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}