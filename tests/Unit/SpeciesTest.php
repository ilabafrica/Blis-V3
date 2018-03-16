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

class SpeciesTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
	public function setVariables(){
		$this->speciesData=array(
			"code"=>'Sample String',
			"display"=>'Sample String',
		);
		$this->updatedSpeciesData=array(
			"code"=>'Sample updated String',
			"display"=>'Sample updated String',
		);
	}

	public function testStoreSpecies()
	{
		$response=$this->post('/api/species',$this->speciesData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("display",$response->original);
	}

	public function testListSpecies()
	{
		$response=$this->get('/api/species');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowSpecies()
	{
		$response=$this->post('/api/species',$this->speciesData);
		$response=$this->get('/api/species/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("display",$response->original);
	}

	public function testUpdateSpecies()
	{
		$response=$this->post('/api/species',$this->speciesData);
		$response=$this->put('/api/species/1',$this->updatedSpeciesData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("display",$response->original);
	}

	public function testDeleteSpecies()
	{
		$response=$this->post('/api/species',$this->speciesData);
		$response=$this->delete('/api/species/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}