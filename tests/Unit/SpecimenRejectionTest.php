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
		factory(\App\Models\RejectionReason::class,2)->create();
		$test = factory(\App\Models\Test::class)->create([
            'encounter_id' => factory(\App\Models\Encounter::class)->create()->id,
            'test_type_id' => factory(\App\Models\TestType::class)->create()->id,
            'specimen_id' => factory(\App\Models\Specimen::class)->create()->id,
            'test_status_id' => \App\Models\TestStatus::completed,
            'created_by' => 1,
            'tested_by' => 1,
            'verified_by' => 1,
            'time_started' =>  date('Y-m-d H:i:s'),
            'time_completed' =>  date('Y-m-d H:i:s'),
            'created_at' =>  date('Y-m-d H:i:s')
        ]);
		$this->specimenRejectionData=array(
			"specimen_id"=>1,
			"test_phase_id"=>1,
			"test_id"=>$test->id,
			"authorized_person_informed"=>1,
			"rejected_by"=>1,
			"time_rejected"=>'Sample String',
			"rejection_reason_ids"=>[1,2],
		);
		$this->updatedSpecimenRejectionData=array(
			"specimen_id"=>1,
			"test_phase_id"=>1,
			"test_id"=>$test->id,
			"authorized_person_informed"=>1,
			"rejected_by"=>1,
			"time_rejected"=>'Sample String',
			"rejection_reason_ids"=>[1,2],
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