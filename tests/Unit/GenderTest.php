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

class GenderTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
	public function setVariables(){
		$this->genderData=array(
			"code"=>'Sample String',
			"display"=>'Sample String',
		);
		$this->updatedGenderData=array(
			"code"=>'Sample updated String',
			"display"=>'Sample updated String',
		);
	}

	public function testStoreGender()
	{
		$response=$this->post('/api/gender',$this->genderData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("display",$response->original);
	}

	public function testListGender()
	{
		$response=$this->get('/api/gender');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowGender()
	{
		$response=$this->post('/api/gender',$this->genderData);
		$response=$this->get('/api/gender/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("display",$response->original);
	}

	public function testUpdateGender()
	{
		$response=$this->post('/api/gender',$this->genderData);
		$response=$this->put('/api/gender/1',$this->updatedGenderData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("display",$response->original);
	}

	public function testDeleteGender()
	{
		$response=$this->post('/api/gender',$this->genderData);
		$response=$this->delete('/api/gender/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}