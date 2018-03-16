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

class AntibioticSusceptibilityTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
	public function setVariables(){
		$this->antibioticSusceptibilityData=array(
			"user_id"=>1,
			"antibiotic_id"=>1,
			"result_id"=>1,
			"susceptibility_range_id"=>1,
			"zone_diameter"=>1,
		);
		$this->updatedAntibioticSusceptibilityData=array(
			"user_id"=>1,
			"antibiotic_id"=>1,
			"result_id"=>1,
			"susceptibility_range_id"=>1,
			"zone_diameter"=>1,
		);
	}

	public function testStoreAntibioticSusceptibility()
	{
		$response=$this->post('/api/antibioticsusceptibility',$this->antibioticSusceptibilityData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("zone_diameter",$response->original);
	}

	public function testListAntibioticSusceptibility()
	{
		$response=$this->get('/api/antibioticsusceptibility');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowAntibioticSusceptibility()
	{
		$response=$this->post('/api/antibioticsusceptibility',$this->antibioticSusceptibilityData);
		$response=$this->get('/api/antibioticsusceptibility/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("zone_diameter",$response->original);
	}

	public function testUpdateAntibioticSusceptibility()
	{
		$response=$this->post('/api/antibioticsusceptibility',$this->antibioticSusceptibilityData);
		$response=$this->put('/api/antibioticsusceptibility/1',$this->updatedAntibioticSusceptibilityData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("zone_diameter",$response->original);
	}

	public function testDeleteAntibioticSusceptibility()
	{
		$response=$this->post('/api/antibioticsusceptibility',$this->antibioticSusceptibilityData);
		$response=$this->delete('/api/antibioticsusceptibility/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}