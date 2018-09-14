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

class ReferralTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
	public function setVariables(){
		$this->referralData=array(
			"time_dispatched_to"=>'Sample String',
			"time_dispatched_from"=>'Sample String',
			"time_receiveded_from"=>'Sample String',
			"specimen_id"=>1,
			"referred_from"=>1,
			"referred_to"=>1,
			"user_id"=>1,
		);
		$this->updatedReferralData=array(
			"time_dispatched_to"=>'Sample String',
			"time_dispatched_from"=>'Sample String',
			"time_receiveded_from"=>'Sample String',
			"specimen_id"=>1,
			"referred_from"=>1,
			"referred_to"=>1,
			"user_id"=>1,
		);
	}

	public function testStoreReferral()
	{
		$response=$this->post('/api/referral',$this->referralData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("user_id",$response->original);
	}

	public function testListReferral()
	{
		$response=$this->get('/api/referral');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowReferral()
	{
		$response=$this->post('/api/referral',$this->referralData);
		$response=$this->get('/api/referral/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("user_id",$response->original);
	}

	public function testUpdateReferral()
	{
		$response=$this->post('/api/referral',$this->referralData);
		$response=$this->put('/api/referral/1',$this->updatedReferralData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("user_id",$response->original);
	}

	public function testDeleteReferral()
	{
		$response=$this->post('/api/referral',$this->referralData);
		$response=$this->delete('/api/referral/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}