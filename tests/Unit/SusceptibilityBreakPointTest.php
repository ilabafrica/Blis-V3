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

class SusceptibilityBreakPointTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
	public function setVariables(){
		$this->susceptibilityBreakPointData=array(
			"antibiotic_id"=>1,
			"measure_range_id"=>1,
			"resistant_max"=>'Sample String',
			"intermediate_min"=>'Sample String',
			"intermediate_max"=>'Sample String',
			"sensitive_min"=>'Sample String',
		);
		$this->updatedSusceptibilityBreakPointData=array(
			"antibiotic_id"=>1,
			"measure_range_id"=>1,
			"resistant_max"=>'Sample updated String',
			"intermediate_min"=>'Sample updated String',
			"intermediate_max"=>'Sample updated String',
			"sensitive_min"=>'Sample updated String',
		);
	}

	public function testStoreSusceptibilityBreakPoint()
	{
		$response=$this->post('/api/susceptibilitybreakpoint',$this->susceptibilityBreakPointData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("sensitive_min",$response->original);
	}

	public function testListSusceptibilityBreakPoint()
	{
		$response=$this->get('/api/susceptibilitybreakpoint');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowSusceptibilityBreakPoint()
	{
		$response=$this->post('/api/susceptibilitybreakpoint',$this->susceptibilityBreakPointData);
		$response=$this->get('/api/susceptibilitybreakpoint/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("sensitive_min",$response->original);
	}

	public function testUpdateSusceptibilityBreakPoint()
	{
		$response=$this->post('/api/susceptibilitybreakpoint',$this->susceptibilityBreakPointData);
		$response=$this->put('/api/susceptibilitybreakpoint/1',$this->updatedSusceptibilityBreakPointData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("sensitive_min",$response->original);
	}

	public function testDeleteSusceptibilityBreakPoint()
	{
		$response=$this->post('/api/susceptibilitybreakpoint',$this->susceptibilityBreakPointData);
		$response=$this->delete('/api/susceptibilitybreakpoint/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}