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

class TestTypeTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
	public function setVariables(){
		$this->testTypeData=array(
			"name"=>'Sample String',
			"description"=>'Sample String',
			"test_type_category_id"=>1,
			"targetTAT"=>'Sample String',
		);
		$this->updatedTestTypeData=array(
			"name"=>'Sample updated String',
			"description"=>'Sample updated String',
			"test_type_category_id"=>1,
			"targetTAT"=>'Sample updated String',
		);
	}

	public function testStoreTestType()
	{
		$response=$this->post('/api/testtype',$this->testTypeData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("targetTAT",$response->original);
	}

	public function testListTestType()
	{
		$response=$this->get('/api/testtype');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowTestType()
	{
		$response=$this->post('/api/testtype',$this->testTypeData);
		$response=$this->get('/api/testtype/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("targetTAT",$response->original);
	}

	public function testUpdateTestType()
	{
		$response=$this->post('/api/testtype',$this->testTypeData);
		$response=$this->put('/api/testtype/1',$this->updatedTestTypeData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("targetTAT",$response->original);
	}

	public function testDeleteTestType()
	{
		$response=$this->post('/api/testtype',$this->testTypeData);
		$response=$this->delete('/api/testtype/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}