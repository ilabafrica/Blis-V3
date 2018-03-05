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

class ReferralTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
		$this->referralData=array(
			"time_dispatch"=>'Sample String',
			"storage_condition"=>'Sample String',
			"transport_type"=>'Sample String',
			"referral_reason_id"=>1,
			"priority_specimen"=>'Sample String',
			"organization_id"=>1,
			"person"=>'Sample String',
			"contacts"=>'Sample String',
			"user_id"=>1,
		);
		$this->updatedReferralData=array(
			"time_dispatch"=>'Sample updated String',
			"storage_condition"=>'Sample updated String',
			"transport_type"=>'Sample updated String',
			"referral_reason_id"=>1,
			"priority_specimen"=>'Sample updated String',
			"organization_id"=>1,
			"person"=>'Sample updated String',
			"contacts"=>'Sample updated String',
			"user_id"=>1,
		);
	}

	public function testStoreReferral()
	{
		$response=$this->json('POST', '/api/referral',$this->referralData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("user_id",$response->original);
	}

	public function testListReferral()
	{
		$response=$this->json('GET', '/api/referral');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowReferral()
	{
		$this->json('POST', '/api/referral',$this->referralData);
		$response=$this->json('GET', '/api/referral/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("user_id",$response->original);
	}

	public function testUpdateReferral()
	{
		$this->json('POST', '/api/referral',$this->referralData);
		$response=$this->json('PUT', '/api/referral/1',$this->updatedReferralData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("user_id",$response->original);
	}

	public function testDeleteReferral()
	{
		$this->json('POST', '/api/referral',$this->referralData);
		$response=$this->delete('/api/referral/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}