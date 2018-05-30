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

class ControlMeasureRangeTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
	public function setVariables(){
		$this->controlMeasureRangeData=array(
			"upper_range"=>'Sample String',
			"lower_range"=>'Sample String',
			"alphanumeric"=>'Sample String',
			"control_measure_id"=>1,
		);
		$this->updatedControlMeasureRangeData=array(
			"upper_range"=>'Sample updated String',
			"lower_range"=>'Sample updated String',
			"alphanumeric"=>'Sample updated String',
			"control_measure_id"=>1,
		);
	}

	public function testStoreControlMeasureRange()
	{
		$response=$this->post('/api/controlmeasurerange',$this->controlMeasureRangeData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("control_measure_id",$response->original);
	}

	public function testListControlMeasureRange()
	{
		$response=$this->get('/api/controlmeasurerange');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowControlMeasureRange()
	{
		$response=$this->post('/api/controlmeasurerange',$this->controlMeasureRangeData);
		$response=$this->get('/api/controlmeasurerange/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("control_measure_id",$response->original);
	}

	public function testUpdateControlMeasureRange()
	{
		$response=$this->post('/api/controlmeasurerange',$this->controlMeasureRangeData);
		$response=$this->put('/api/controlmeasurerange/1',$this->updatedControlMeasureRangeData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("control_measure_id",$response->original);
	}

	public function testDeleteControlMeasureRange()
	{
		$response=$this->post('/api/controlmeasurerange',$this->controlMeasureRangeData);
		$response=$this->delete('/api/controlmeasurerange/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}