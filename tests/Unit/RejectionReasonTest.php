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

class RejectionReasonTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
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
		$response=$this->post('/api/rejectionreason',$this->rejectionReasonData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testListRejectionReason()
	{
		$response=$this->get('/api/rejectionreason');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowRejectionReason()
	{
		$response=$this->post('/api/rejectionreason',$this->rejectionReasonData);
		$response=$this->get('/api/rejectionreason/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testUpdateRejectionReason()
	{
		$response=$this->post('/api/rejectionreason',$this->rejectionReasonData);
		$response=$this->put('/api/rejectionreason/1',$this->updatedRejectionReasonData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testDeleteRejectionReason()
	{
		$response=$this->post('/api/rejectionreason',$this->rejectionReasonData);
		$response=$this->delete('/api/rejectionreason/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}