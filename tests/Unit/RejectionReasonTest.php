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

class RejectionReasonTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
		$this->rejectionReasonData=array(
			"name"=>'Sample String',
		);
		$this->updatedRejectionReasonData=array(
			"name"=>'Sample updated String',
		);
	}

	public function testStoreRejectionReason()
	{
		$response=$this->json('POST', '/api/rejectionreason',$this->rejectionReasonData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testListRejectionReason()
	{
		$response=$this->json('GET', '/api/rejectionreason');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowRejectionReason()
	{
		$this->json('POST', '/api/rejectionreason',$this->rejectionReasonData);
		$response=$this->json('GET', '/api/rejectionreason/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testUpdateRejectionReason()
	{
		$this->json('POST', '/api/rejectionreason',$this->rejectionReasonData);
		$response=$this->json('PUT', '/api/rejectionreason/1',$this->updatedRejectionReasonData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testDeleteRejectionReason()
	{
		$this->json('POST', '/api/rejectionreason',$this->rejectionReasonData);
		$response=$this->delete('/api/rejectionreason/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}