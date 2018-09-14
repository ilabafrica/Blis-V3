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

class ControlResultTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
	public function setVariables(){
		//
	}

	public function testStoreControlResult()
	{

		$controlTest = factory(\App\Models\ControlTest::class)->create();


		$measure = factory(\App\Models\Measure::class)->create([
			'test_type_id' => $controlTest->id,
			'measure_type_id' => \App\Models\MeasureType::free_text,
		]);

		$response=$this->post('/api/controlresult',[
			"control_test_id"=>$controlTest->id,
			"measure_id"=>$measure->id,
			"result"=>'44:7',
		]);

		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("lot",$response->original);
	}

}