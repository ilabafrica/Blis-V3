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

class AdhocCategoryTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
	public function setVariables(){
		$this->adhocCategoryData=array(
			"code"=>'Sample String',
			"display"=>'Sample String',
		);
		$this->updatedAdhocCategoryData=array(
			"code"=>'Sample updated String',
			"display"=>'Sample updated String',
		);
	}

	public function testStoreAdhocCategory()
	{
		$response=$this->post('/api/adhoccategory',$this->adhocCategoryData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("display",$response->original);
	}

	public function testListAdhocCategory()
	{
		$response=$this->get('/api/adhoccategory');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowAdhocCategory()
	{
		$response=$this->post('/api/adhoccategory',$this->adhocCategoryData);
		$response=$this->get('/api/adhoccategory/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("display",$response->original);
	}

	public function testUpdateAdhocCategory()
	{
		$response=$this->post('/api/adhoccategory',$this->adhocCategoryData);
		$response=$this->put('/api/adhoccategory/1',$this->updatedAdhocCategoryData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("display",$response->original);
	}

	public function testDeleteAdhocCategory()
	{
		$response=$this->post('/api/adhoccategory',$this->adhocCategoryData);
		$response=$this->delete('/api/adhoccategory/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}