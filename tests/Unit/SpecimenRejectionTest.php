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

class SpecimenRejectionTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
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
		$response=$this->post('/api/specimenrejection',$this->specimenRejectionData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("time_rejected",$response->original);
	}

	public function testListSpecimenRejection()
	{
		$response=$this->get('/api/specimenrejection');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowSpecimenRejection()
	{
		$response=$this->post('/api/specimenrejection',$this->specimenRejectionData);
		$response=$this->get('/api/specimenrejection/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("time_rejected",$response->original);
	}

	public function testUpdateSpecimenRejection()
	{
		$response=$this->post('/api/specimenrejection',$this->specimenRejectionData);
		$response=$this->put('/api/specimenrejection/1',$this->updatedSpecimenRejectionData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("time_rejected",$response->original);
	}

	public function testDeleteSpecimenRejection()
	{
		$response=$this->post('/api/specimenrejection',$this->specimenRejectionData);
		$response=$this->delete('/api/specimenrejection/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}