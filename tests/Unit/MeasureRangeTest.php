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

class MeasureRangeTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
		$this->measureRangeData=array(
			"code"=>'Sample String',
			"system"=>'Sample String',
			"measure_id"=>1,
			"age_min"=>'Sample String',
			"age_max"=>'Sample String',
			"gender_id"=>1,
			"low"=>'Sample String',
			"high"=>'Sample String',
			"low_critical"=>'Sample String',
			"high_critical"=>'Sample String',
			"alphanumeric_range"=>'Sample String',
			"interpretation_id"=>1,
		);
		$this->updatedMeasureRangeData=array(
			"code"=>'Sample updated String',
			"system"=>'Sample updated String',
			"measure_id"=>1,
			"age_min"=>'Sample updated String',
			"age_max"=>'Sample updated String',
			"gender_id"=>1,
			"low"=>'Sample updated String',
			"high"=>'Sample updated String',
			"low_critical"=>'Sample updated String',
			"high_critical"=>'Sample updated String',
			"alphanumeric_range"=>'Sample updated String',
			"interpretation_id"=>1,
		);
	}

	public function testStoreMeasureRange()
	{
		$response=$this->json('POST', '/api/measurerange',$this->measureRangeData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("interpretation_id",$response->original);
	}

	public function testListMeasureRange()
	{
		$response=$this->json('GET', '/api/measurerange');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowMeasureRange()
	{
		$this->json('POST', '/api/measurerange',$this->measureRangeData);
		$response=$this->json('GET', '/api/measurerange/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("interpretation_id",$response->original);
	}

	public function testUpdateMeasureRange()
	{
		$this->json('POST', '/api/measurerange',$this->measureRangeData);
		$response=$this->json('PUT', '/api/measurerange/1',$this->updatedMeasureRangeData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("interpretation_id",$response->original);
	}

	public function testDeleteMeasureRange()
	{
		$this->json('POST', '/api/measurerange',$this->measureRangeData);
		$response=$this->delete('/api/measurerange/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}