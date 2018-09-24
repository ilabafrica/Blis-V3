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

class ResultTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;

	public function setVariables(){
		//
	}

	public function testFreeTextResult()
	{

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

		$measure = factory(\App\Models\Measure::class)->create([
			'test_type_id' => $test->id,
			'measure_type_id' => \App\Models\MeasureType::free_text,
		]);

		$storeResponse=$this->post('/api/result',[
			"test_id"=>$test->id,
			"measures" => [
				$measure->id => [
					"result"=>'Sample String',
				]
			]
		]);

		$this->assertEquals(200,$storeResponse->getStatusCode());
		$this->assertArrayHasKey("results",$storeResponse->original);
	}
}