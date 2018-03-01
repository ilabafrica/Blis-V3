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

class TestTypeCategoryTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
		$this->testTypeCategoryData=array(
			"code"=>'Sample String',
			"name"=>'Sample String',
		);
		$this->updatedTestTypeCategoryData=array(
			"code"=>'Sample updated String',
			"name"=>'Sample updated String',
		);
	}

	public function testStoreTestTypeCategory()
	{
		$response=$this->json('POST', '/api/testtypecategory',$this->testTypeCategoryData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testListTestTypeCategory()
	{
		$response=$this->json('GET', '/api/testtypecategory');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowTestTypeCategory()
	{
		$this->json('POST', '/api/testtypecategory',$this->testTypeCategoryData);
		$response=$this->json('GET', '/api/testtypecategory/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testUpdateTestTypeCategory()
	{
		$this->json('POST', '/api/testtypecategory',$this->testTypeCategoryData);
		$response=$this->json('PUT', '/api/testtypecategory/1',$this->updatedTestTypeCategoryData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testDeleteTestTypeCategory()
	{
		$this->json('POST', '/api/testtypecategory',$this->testTypeCategoryData);
		$response=$this->delete('/api/testtypecategory/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}