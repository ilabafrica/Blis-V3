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

class ReferralReasonTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
	public function setVariables(){
		$this->referralReasonData=array(
			"display"=>'Sample String',
		);
		$this->updatedReferralReasonData=array(
			"display"=>'Sample updated String',
		);
	}

	public function testStoreReferralReason()
	{
		$response=$this->post('/api/referralreason',$this->referralReasonData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("display",$response->original);
	}

	public function testListReferralReason()
	{
		$response=$this->get('/api/referralreason');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowReferralReason()
	{
		$response=$this->post('/api/referralreason',$this->referralReasonData);
		$response=$this->get('/api/referralreason/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("display",$response->original);
	}

	public function testUpdateReferralReason()
	{
		$response=$this->post('/api/referralreason',$this->referralReasonData);
		$response=$this->put('/api/referralreason/1',$this->updatedReferralReasonData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("display",$response->original);
	}

	public function testDeleteReferralReason()
	{
		$response=$this->post('/api/referralreason',$this->referralReasonData);
		$response=$this->delete('/api/referralreason/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}