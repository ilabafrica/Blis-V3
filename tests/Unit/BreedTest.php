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

class BreedTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
	public function setVariables(){
		$this->breedData=array(
			"species_id"=>1,
			"code"=>'Sample String',
			"display"=>'Sample String',
		);
		$this->updatedBreedData=array(
			"species_id"=>1,
			"code"=>'Sample updated String',
			"display"=>'Sample updated String',
		);
	}

	public function testStoreBreed()
	{
		$response=$this->post('/api/breed',$this->breedData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("display",$response->original);
	}

	public function testListBreed()
	{
		$response=$this->get('/api/breed');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowBreed()
	{
		$response=$this->post('/api/breed',$this->breedData);
		$response=$this->get('/api/breed/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("display",$response->original);
	}

	public function testUpdateBreed()
	{
		$response=$this->post('/api/breed',$this->breedData);
		$response=$this->put('/api/breed/1',$this->updatedBreedData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("display",$response->original);
	}

	public function testDeleteBreed()
	{
		$response=$this->post('/api/breed',$this->breedData);
		$response=$this->delete('/api/breed/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}