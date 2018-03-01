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

class ReferralReasonTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
		$this->referralReasonData=array(
			"name"=>'Sample String',
		);
		$this->updatedReferralReasonData=array(
			"name"=>'Sample updated String',
		);
	}

	public function testStoreReferralReason()
	{
		$response=$this->json('POST', '/api/referralreason',$this->referralReasonData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testListReferralReason()
	{
		$response=$this->json('GET', '/api/referralreason');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowReferralReason()
	{
		$this->json('POST', '/api/referralreason',$this->referralReasonData);
		$response=$this->json('GET', '/api/referralreason/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testUpdateReferralReason()
	{
		$this->json('POST', '/api/referralreason',$this->referralReasonData);
		$response=$this->json('PUT', '/api/referralreason/1',$this->updatedReferralReasonData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testDeleteReferralReason()
	{
		$this->json('POST', '/api/referralreason',$this->referralReasonData);
		$response=$this->delete('/api/referralreason/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}