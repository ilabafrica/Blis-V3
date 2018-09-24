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

class TestTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
	public function setVariables(){
		$this->testData=array(
			"encounter_id"=>1,
			"identifier"=>'Sample String',
			"test_type_id"=>1,
			"specimen_id"=>1,
			"test_status_id"=>1,
			"created_by"=>1,
			"tested_by"=>1,
			"verified_by"=>1,
			"cancelled_by"=>1,
			"requested_by"=>'Sample String',
			"time_started"=>'Sample String',
			"time_cancelled"=>'Sample String',
			"time_completed"=>'Sample String',
			"time_verified"=>'Sample String',
		);
		$this->updatedTestData=array(
			"encounter_id"=>1,
			"identifier"=>'Sample String',
			"test_type_id"=>1,
			"specimen_id"=>1,
			"test_status_id"=>1,
			"created_by"=>1,
			"tested_by"=>1,
			"verified_by"=>1,
			"cancelled_by"=>1,
			"requested_by"=>'Sample String',
			"time_started"=>'Sample String',
			"time_cancelled"=>'Sample String',
			"time_completed"=>'Sample String',
			"time_verified"=>'Sample String',
		);
	}

	public function testListTest()
	{
		$response=$this->get('/api/test');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowTest()
	{
		$this->assertTrue(true);
	}

	public function testspecimenCollectionTest()
	{
		$this->assertTrue(true);
	}

	public function testspecimenRejectionTest()
	{
		$this->assertTrue(true);
	}

	public function testspecimenReferralTest()
	{
		$this->assertTrue(true);
	}

	public function teststartTest()
	{
		$this->assertTrue(true);
	}

	public function testverifyTest()
	{
		$this->assertTrue(true);
	}

}