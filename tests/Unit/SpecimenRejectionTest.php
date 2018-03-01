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

class SpecimenRejectionTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
		$this->specimenRejectionData=array(
			"specimen_id"=>1,
			"test_phase_id"=>1,
			"test_id"=>1,
			"rejected_by"=>1,
			"rejection_reason_id"=>1,
			"reject_explained_to"=>'Sample String',
			"time_rejected"=>'Sample String',
		);
		$this->updatedSpecimenRejectionData=array(
			"specimen_id"=>1,
			"test_phase_id"=>1,
			"test_id"=>1,
			"rejected_by"=>1,
			"rejection_reason_id"=>1,
			"reject_explained_to"=>'Sample updated String',
			"time_rejected"=>'Sample updated String',
		);
	}

	public function testStoreSpecimenRejection()
	{
		$response=$this->json('POST', '/api/specimenrejection',$this->specimenRejectionData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("time_rejected",$response->original);
	}

	public function testListSpecimenRejection()
	{
		$response=$this->json('GET', '/api/specimenrejection');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowSpecimenRejection()
	{
		$this->json('POST', '/api/specimenrejection',$this->specimenRejectionData);
		$response=$this->json('GET', '/api/specimenrejection/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("time_rejected",$response->original);
	}

	public function testUpdateSpecimenRejection()
	{
		$this->json('POST', '/api/specimenrejection',$this->specimenRejectionData);
		$response=$this->json('PUT', '/api/specimenrejection/1',$this->updatedSpecimenRejectionData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("time_rejected",$response->original);
	}

	public function testDeleteSpecimenRejection()
	{
		$this->json('POST', '/api/specimenrejection',$this->specimenRejectionData);
		$response=$this->delete('/api/specimenrejection/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}