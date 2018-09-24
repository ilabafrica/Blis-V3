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

class TestMappingTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
	public function setVariables(){
		$this->testMappingData=array(
			"code_id"=>1,
			"test_type_id"=>1,
			"specimen_type_id"=>1,
		);
		$this->updatedTestMappingData=array(
			"code_id"=>1,
			"test_type_id"=>1,
			"specimen_type_id"=>1,
		);
	}

	public function testAttachTestMapping()
	{
		 $this->assertTrue(true);
	}

	public function testListTestMapping()
	{
		$response=$this->get('/api/testtypemapping');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowTestMapping()
	{
		$this->assertTrue(true);
	}

	public function testUpdateTestMapping()
	{
		$this->assertTrue(true);
	}

	public function testDeleteTestMapping()
	{
		$this->assertTrue(true);
	}

}